<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;



class CartController extends Controller
{
    public function index()
    {
        $userId    = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        // cart query (user wise / session wise)
        $cartQuery = Cart::query();

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->whereNull('user_id')
                    ->where('session_id', $sessionId);
        }

        $cartProducts = $cartQuery->get();
        $cartCount    = $cartQuery->sum('quantity'); // চাইলে ->count()

        $products    = Product::select('id', 'name', 'image')->get();
        $categories  = Category::all();

        return view('home.cart.index', compact('cartProducts', 'products', 'cartCount', 'categories'));
    }

    // Add to Cart
    public function addToCart($id)
    {
        // dd($id);
        $product = Product::find($id);

        if (!$product) {
            return back()->with('error', 'Product not found!');
        }

        $userId = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        // Find cart item for this user OR guest session
        $query = Cart::where('product_id', $product->id);

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id')
                ->where('session_id', $sessionId);
        }

        $cartItem = $query->first();

        if (!$cartItem) {
            Cart::create([
                'user_id'     => $userId,                 // null if guest
                'session_id'  => $userId ? null : $sessionId,
                'product_id'  => $product->id,
                'quantity'    => 1,
                'unit_price'  => $product->price,
                'total_price' => $product->price,
            ]);
        } else {
            $cartItem->quantity = $cartItem->quantity + 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->unit_price;
            $cartItem->save();
        }

        return back()->with('success', 'Product added to cart!');
    }

    // change product quantity
    public function updateCart(Request $request, $id)
    {
        $cart = DB::table('carts')->where('id', $id)->first();

        DB::table('carts')->where('id', $id)->update([
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $cart->unit_price
        ]);

        return back()->with('success', 'Product quantity Changed!');
    }

    public function updateQuantity(Request $request)
{
    $request->validate([
        'cart_id'  => 'required|integer|exists:carts,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $userId    = Auth::check() ? Auth::id() : null;
    $sessionId = session()->getId();

    $cartQuery = Cart::where('id', $request->cart_id);

    if ($userId) {
        $cartQuery->where('user_id', $userId);
    } else {
        $cartQuery->whereNull('user_id')->where('session_id', $sessionId);
    }

    $cart = $cartQuery->firstOrFail();

    $cart->quantity    = (int) $request->quantity;
    $cart->total_price = $cart->quantity * $cart->unit_price;
    $cart->save();

    // cart totals
    $totalQuery = Cart::query();
    if ($userId) {
        $totalQuery->where('user_id', $userId);
    } else {
        $totalQuery->whereNull('user_id')->where('session_id', $sessionId);
    }

    $cartSubtotal = (float) $totalQuery->sum('total_price');

    return response()->json([
        'ok'           => true,
        'cart_id'      => $cart->id,
        'quantity'     => $cart->quantity,
        'row_total'    => (float) $cart->total_price,
        'cart_subtotal'=> $cartSubtotal,
    ]);
}

    // delete cart-item
    public function deleteItem($id)
    {
        DB::table('carts')->where('id', $id)->delete();

        return back()->with('success', 'Item removed from the cart!');
    }

    public function checkout()
    {
        $userId    = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();

        $cartQuery = Cart::query();

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->whereNull('user_id')
                    ->where('session_id', $sessionId);
        }

        $cartProducts = $cartQuery->get();
        $cartCount    = $cartQuery->sum('quantity'); // চাইলে ->count()

        $products   = Product::select('id', 'name', 'image')->get();
        $categories = Category::all();

        return view('home.cart.checkout', compact('cartProducts', 'products', 'categories', 'cartCount'));
    }

    // one-page-checkout
    public function onepagecheckout($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return back()->with('error', 'Product not found!');
        }
    
        $userId    = Auth::check() ? Auth::id() : null;
        $sessionId = session()->getId();
    
        // Optional (recommended): One-page checkout হলে আগের cart ক্লিয়ার করে দিন
        // যাতে পুরানো item/duplicate issue না হয়
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        } else {
            Cart::whereNull('user_id')->where('session_id', $sessionId)->delete();
        }
    
        // এখন শুধু ১টা quantity দিয়ে add করুন
        Cart::create([
            'user_id'     => $userId,
            'session_id'  => $userId ? null : $sessionId,
            'product_id'  => $product->id,
            'quantity'    => 1,
            'unit_price'  => (float) $product->price,
            'total_price' => (float) $product->price,
        ]);
    
        return redirect()->route('cart.checkout');
    }

//     public function confirmOrder(Request $request)
// {
//     $request->validate([
//         'name'         => 'required|string|max:50',
//         'email'        => 'required|email|max:50',
//         'phone_number' => 'required|string|min:11|max:20',
//         'address'      => 'required|string|max:255',
//         'delivery_fee' => 'required|numeric|min:0',
//     ]);

//     $sessionId = session()->getId();
//     $createdBy = Auth::check() ? Auth::id() : null;

//     // ✅ Get cart items from DB (NOT from request arrays)
//     $cartQuery = Cart::query();
//     if ($createdBy) {
//         $cartQuery->where('user_id', $createdBy);
//     } else {
//         $cartQuery->whereNull('user_id')->where('session_id', $sessionId);
//     }

//     $cartItems = $cartQuery->get();

//     if ($cartItems->isEmpty()) {
//         return back()->with('error', 'Your cart is empty!');
//     }

//     // ✅ Merge duplicates safely: product_id wise qty sum
//     $merged = [];
//     foreach ($cartItems as $item) {
//         $pid = (int) $item->product_id;

//         if (!isset($merged[$pid])) {
//             $merged[$pid] = [
//                 'qty'   => 0,
//                 'unit'  => (float) $item->unit_price,
//                 'total' => 0,
//             ];
//         }

//         $merged[$pid]['qty']   += (int) $item->quantity;
//         $merged[$pid]['unit']   = (float) $item->unit_price; // keep unit
//         $merged[$pid]['total'] += ((int)$item->quantity * (float)$item->unit_price);
//     }

//     $subTotal    = array_sum(array_column($merged, 'total'));
//     $deliveryFee = (float) $request->delivery_fee;
//     $grandTotal  = $subTotal + $deliveryFee;

//     $invoice = DB::transaction(function () use ($request, $merged, $sessionId, $createdBy, $subTotal, $grandTotal, $deliveryFee) {

//         // ✅ Customer find/create/update
//         $customer = Customer::where('email', $request->email)
//             ->orWhere('mobile_no', $request->phone_number)
//             ->first();

//         if (!$customer) {
//             $customer = Customer::create([
//                 'name'       => $request->name,
//                 'mobile_no'  => $request->phone_number,
//                 'email'      => $request->email,
//                 'address'    => $request->address,
//                 'created_by' => $createdBy,
//             ]);
//         } else {
//             $customer->update([
//                 'name'      => $request->name,
//                 'mobile_no' => $request->phone_number,
//                 'email'     => $request->email,
//                 'address'   => $request->address,
//             ]);
//         }

//         // ✅ Invoice create
//         $invoice = Invoice::create([
//             'invoice_no'    => $request->invoice_no ?? ('INV-' . now()->format('YmdHis')),
//             'date'          => now()->toDateString(),
//             'description'   => $request->description ?? 'Online Order',
//             'status'        => '0',
//             'delivery_fee'  => $deliveryFee,
//             'created_by'    => $createdBy,
//         ]);

//         // ✅ Fetch products only once
//         $productsById = Product::whereIn('id', array_keys($merged))->get()->keyBy('id');

//         foreach ($merged as $pid => $row) {
//             $product = $productsById->get((int) $pid);
//             if (!$product) continue;

//             InvoiceDetail::create([
//                 'date'          => now()->toDateString(),
//                 'invoice_id'    => $invoice->id,
//                 'category_id'   => $product->category_id,
//                 'product_id'    => $product->id,
//                 'selling_qty'   => (int) $row['qty'],
//                 'unit_price'    => (float) $row['unit'],
//                 'selling_price' => (float) $row['total'],
//                 'status'        => '0',
//             ]);
//         }

//         Payment::create([
//             'invoice_id'      => $invoice->id,
//             'customer_id'     => $customer->id,
//             'paid_status'     => 'full_due',
//             'discount_amount' => 0,
//             'total_amount'    => $grandTotal,
//             'paid_amount'     => 0,
//             'due_amount'      => $grandTotal,
//         ]);

//         PaymentDetail::create([
//             'invoice_id'          => $invoice->id,
//             'date'                => now()->toDateString(),
//             'current_paid_amount' => 0,
//         ]);

//         // ✅ Clear cart
//         if ($createdBy) {
//             Cart::where('user_id', $createdBy)->delete();
//         } else {
//             Cart::whereNull('user_id')->where('session_id', $sessionId)->delete();
//         }

//         return $invoice;
//     });



//     return redirect()
//         ->route('order.thankyou', $invoice->id)
//         ->with('success', 'Order Complete!');
// }



public function confirmOrder(Request $request)
{
    // dd($request->all());

    $request->validate([
        'name'         => 'required|string|max:50',
        'email'        => 'required|email|max:50',
        'phone_number' => 'required|string|min:11|max:20',
        'address'      => 'required|string|max:255',
        'delivery_fee' => 'required|numeric|min:0',
    ]);

    $name = trim($request->name);
    $parts = preg_split('/\s+/', $name);
    $firstName = strtolower($parts[0] ?? '');


    $sessionId = session()->getId();

    $showDefaultPassMsg = false;
    $defaultPassMsg = null;

    // ✅ Step-1: User create/find
    $user = \App\Models\User::where('email', $request->email)
        ->first();

    if (!$user) {
        // default password (better: random + sms/email)
        $user = \App\Models\User::create([
            'name'         => $request->name,
            'username'     => $firstName,
            'email'        => $request->email,
            'address'        => $request->address,
            'phone_number'        => $request->phone_number,
            'password'     => Hash::make('12345678'), // or Str::random(10)
        ]);

        if ($user->wasRecentlyCreated) {
            $showDefaultPassMsg = true;
            $defaultPassMsg = "Your default password is 12345678. Please change your password from the dashboard for security.";
        }
    } else {
        // optional update user info
        $user->update([
            'name'         => $request->name,
            'phone_number' => $request->phone_number,
            'username'     => $firstName,
            'email'        => $request->email,
            'address'      => $request->address,
        ]);
    }

    // ✅ Step-2: Login user
    Auth::login($user);
    $createdBy = $user->id;

    // ✅ Step-3: Session cart -> user cart migrate (VERY IMPORTANT)
    \App\Models\Cart::whereNull('user_id')
        ->where('session_id', $sessionId)
        ->update([
            'user_id'     => $createdBy,
            'session_id'  => null,
        ]);

    // ✅ Step-4: Get cart items from DB (user cart)
    $cartItems = \App\Models\Cart::where('user_id', $createdBy)->get();

    if ($cartItems->isEmpty()) {
        return back()->with('error', 'Your cart is empty!');
    }

    // ✅ Merge duplicates product wise
    $merged = [];
    foreach ($cartItems as $item) {
        $pid = (int) $item->product_id;

        if (!isset($merged[$pid])) {
            $merged[$pid] = ['qty' => 0, 'unit' => (float)$item->unit_price, 'total' => 0];
        }

        $merged[$pid]['qty']   += (int) $item->quantity;
        $merged[$pid]['unit']   = (float) $item->unit_price;
        $merged[$pid]['total'] += ((int)$item->quantity * (float)$item->unit_price);
    }

    $subTotal    = array_sum(array_column($merged, 'total'));
    $deliveryFee = (float) $request->delivery_fee;
    $grandTotal  = $subTotal + $deliveryFee;

    $invoice = DB::transaction(function () use ($request, $merged, $createdBy, $subTotal, $grandTotal, $deliveryFee) {

        // ✅ Step-5: Customer create/update (user wise)
        $customer = \App\Models\Customer::firstOrCreate(
            ['email' => $request->email],
            [
                'name'       => $request->name,
                'mobile_no'  => $request->phone_number,
                'address'    => $request->address,
                'created_by' => $createdBy,
            ]
        );

        // update always
        $customer->update([
            'name'      => $request->name,
            'mobile_no' => $request->phone_number,
            'email'     => $request->email,
            'address'   => $request->address,
        ]);

        // ✅ Invoice create
        $invoice = \App\Models\Invoice::create([
            'invoice_no'   => $request->invoice_no ?? ('INV-' . now()->format('YmdHis')),
            'date'         => now()->toDateString(),
            'description'  => $request->description ?? 'Online Order',
            'status'       => '0',
            'date'         => now(),
            'order_status' => 1,
            'user_id'      => $createdBy,
            'delivery_fee' => $deliveryFee,
            'created_by'   => $createdBy,
        ]);

        // ✅ Fetch products once
        $productsById = \App\Models\Product::whereIn('id', array_keys($merged))->get()->keyBy('id');

        foreach ($merged as $pid => $row) {
            $product = $productsById->get((int)$pid);
            if (!$product) continue;

            \App\Models\InvoiceDetail::create([
                'date'          => now()->toDateString(),
                'invoice_id'    => $invoice->id,
                'category_id'   => $product->category_id,
                'product_id'    => $product->id,
                'selling_qty'   => (int) $row['qty'],
                'unit_price'    => (float) $row['unit'],
                'selling_price' => (float) $row['total'],
                'status'        => '0',
            ]);
        }

        \App\Models\Payment::create([
            'invoice_id'      => $invoice->id,
            'customer_id'     => $customer->id,
            'paid_status'     => 'full_due',
            'discount_amount' => 0,
            'total_amount'    => $grandTotal,
            'paid_amount'     => 0,
            'due_amount'      => $grandTotal,
        ]);

        \App\Models\PaymentDetail::create([
            'invoice_id'          => $invoice->id,
            'date'                => now()->toDateString(),
            'current_paid_amount' => 0,
        ]);

        // ✅ Clear user cart
        \App\Models\Cart::where('user_id', $createdBy)->delete();

        return $invoice;
    });

    $redirect = redirect()
        ->route('order.thankyou', $invoice->id)
        ->with('success', 'Order Complete!');

    if ($showDefaultPassMsg === true) {
        $redirect->with('default_pass_msg', $defaultPassMsg);
    }

    return $redirect;

}





    public function thankYou(Invoice $invoice)
    {
        return view('home.cart.thankyou', compact('invoice'));
    }

}
