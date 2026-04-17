<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductImageGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductAll()
    {
        $products = Product::latest()->get();
        return view('admin.backend.product.product-all', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ProductAdd()
    {
        $supplier = Supplier::latest()->get();
        $category = Category::latest()->get();
        $unit = Unit::latest()->get();
        return view('admin.backend.product.product-add', compact('supplier', 'category', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

 public function ProductStore(Request $request)
{
    //  dd($request->all()); // ✅ Debug দরকার হলে validate এর পরে দিন

    $request->validate([
        'name' => 'required|string|max:255',
        'short_description' => 'nullable|string|max:500',
        'product_details' => 'required|string',
    ]);

    // Product image upload
    $path = 'images/products/';
    if (!file_exists(public_path($path))) {
        @mkdir(public_path($path), 0777, true);
    }

    $img = time() . '_' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
    $request->file('image')->move(public_path($path), $img);

    // Create product
    $product = Product::create([
        'name' => $request->name,
        'type' => $request->type,
        'short_description' => $request->short_description,
        'product_details' => $request->product_details,

        'price' => $request->price,
        'selling_price' => $request->selling_price,
        'old_price' => $request->old_price,

        'image' => $path . $img,
        'supplier_id' => $request->supplier_id,
        'unit_id' => $request->unit_id,
        'category_id' => $request->category_id,

        'created_by' => Auth::id(),
        'created_at' => Carbon::now(),
    ]);



    // Save reviews
    $path2 = 'images/reviewimage/';
    if (!file_exists(public_path($path2))) {
        @mkdir(public_path($path2), 0777, true);
    }

    $names = $request->user_name;
    $ratings = $request->rating;
    $texts = $request->text;

    foreach ($names as $i => $uname) {
        $review = new Review();
        $review->product_id = $product->id;
        $review->user_name = $uname;

        // ✅ FIX: rating array থেকে index অনুযায়ী নিবে
        $review->rating = $ratings[$i] ?? null;

        $review->text = $texts[$i] ?? null;

        // ✅ profile image per row (optional)
        if ($request->hasFile("profile.$i")) {
            $file = $request->file("profile.$i");
            $img2 = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path2), $img2);
            $review->review_image = $path2 . $img2;
        }

        $review->save();
    }


    $path3 = 'images/gallery_image/';
    if (!file_exists(public_path($path3))) {
        mkdir(public_path($path3), 0777, true);
    }
    $galleryFiles = $request->file('gallery_image', []); // ✅ always array
    foreach ($galleryFiles as $i => $file) {
        if (!$file || !$file->isValid()) {
            continue;
        }

        $gallery = new ProductImageGallery();
        $gallery->product_id = $product->id;

        $img3 = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path3), $img3);

        $gallery->gallery_image = $path3 . $img3; // store relative path
        $gallery->save();
    }


    return redirect()->route('product.all')->with([
        'message' => 'Product Insert Successfully',
        'alert-type' => 'success'
    ]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function ProductEdit(Product $product, $id)
    {
        $product  = Product::findOrFail($id);
        $supplier = Supplier::latest()->get();
        $category = Category::latest()->get();
        $unit     = Unit::latest()->get();

        $reviews  = Review::where('product_id', $id)->latest()->get();

        return view('admin.backend.product.product-edit', compact(
            'supplier', 'category', 'unit', 'product', 'reviews'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
  public function ProductUpdate(Request $request, Product $product)
{
    // dd($request->all());

    $request->validate([
        'name' => 'required|string|max:255',
        'product_details' => 'required|string',
        'price' => 'required|integer',
        'selling_price' => 'required|numeric|between:0.01,999999.99',
        'old_price' => 'required|numeric|between:0.01,999999.99',
    ]);

    /* ================= PRODUCT IMAGE UPDATE ================= */
    if ($request->hasFile('image')) {

        // delete old product image
        if (!empty($product->image)) {
            $oldPath = public_path($product->image);
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $img = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
        $path = 'images/products/';
        if (!file_exists(public_path($path))) {
            @mkdir(public_path($path), 0777, true);
        }
        $request->image->move(public_path($path), $img);

        // update product image field
        $product->image = $path . $img;
    }

    /* ================= PRODUCT DATA UPDATE ================= */
    $product->update([
        'name' => $request->name,
        'type' => $request->type,
        'short_description' => $request->short_description,
        'product_details' => $request->product_details,
        'price' => $request->price,
        'selling_price' => $request->selling_price,
        'old_price' => $request->old_price,
        'supplier_id' => $request->supplier_id,
        'unit_id' => $request->unit_id,
        'category_id' => $request->category_id,
        'updated_by' => Auth::id(),
    ]);

    /* ================= DELETE EXISTING REVIEWS (optional) ================= */
    if ($request->filled('delete_review_ids')) {
        $deleteIds = $request->delete_review_ids;

        $toDelete = Review::where('product_id', $product->id)
            ->whereIn('id', $deleteIds)
            ->get();

        foreach ($toDelete as $rev) {
            if (!empty($rev->review_image)) {
                $imgPath = public_path($rev->review_image);
                if (File::exists($imgPath)) {
                    File::delete($imgPath);
                }
            }
            $rev->delete();
        }
    }

    /* ================= ADD NEW REVIEWS (table inputs) ================= */
    $names   = $request->input('user_name', []);
    $ratings = $request->input('rating', []);
    $texts   = $request->input('text', []);

    $path2 = 'images/reviewimage/';
    if (!file_exists(public_path($path2))) {
        @mkdir(public_path($path2), 0777, true);
    }

    // Loop by index to keep alignment (name/text/profile/rating)
    foreach ($names as $i => $uname) {

        $uname  = trim((string)$uname);
        $rtext  = isset($texts[$i]) ? trim((string)$texts[$i]) : '';
        $rrate  = isset($ratings[$i]) ? $ratings[$i] : null;

        // যদি row একদম ফাঁকা থাকে, skip
        $hasFile = $request->hasFile("profile.$i");
        if ($uname === '' && $rtext === '' && !$hasFile && ($rrate === null || $rrate === '')) {
            continue;
        }

        $review = new Review();
        $review->product_id = $product->id;
        $review->user_name  = $uname;
        $review->rating     = $rrate;     // ✅ FIX: per-row rating
        $review->text       = $rtext;

        // profile image per row
        if ($hasFile) {
            $file = $request->file("profile.$i");
            $img2 = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($path2), $img2);
            $review->review_image = $path2 . $img2;
        }

        $review->save();
    }

    
    $path3 = 'images/gallery_image/';
    if (!file_exists(public_path($path3))) {
        mkdir(public_path($path3), 0777, true);
    }
    $galleryFiles = $request->file('gallery_image', []); // ✅ always array
    foreach ($galleryFiles as $i => $file) {
        if (!$file || !$file->isValid()) {
            continue;
        }

        $gallery = new ProductImageGallery();
        $gallery->product_id = $product->id;

        $img3 = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($path3), $img3);

        $gallery->gallery_image = $path3 . $img3; // store relative path
        $gallery->save();
    }


        return redirect()->route('product.all')->with([
            'message' => 'Product Update Successfully',
            'alert-type' => 'success'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function ProductDelete(Product $product, $id)
    {
        // Fetch the image path from DB first
        $product = DB::table('products')->where('id', $id)->first();


        if ($product) {
            // Build the full path to the image
            $imagePath = public_path($product->image);

            // Check if the file exists before deleting
            if (!empty($product->image) && File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the record from database
            DB::table('products')->where('id', $id)->delete();

            return redirect()->back()->with('success', 'Product deleted successfully.');
        }

        return redirect()->back()->with('error', 'Product not found.');
    }

    public function deleteGalleryImage($id)
{
    $img = ProductImageGallery::findOrFail($id);


    // file delete
    $fullPath = public_path($img->image_path);
    if (file_exists($fullPath)) {
        @unlink($fullPath);
    }

    $img->delete();

    return response()->json(['ok' => true]);
}

public function reviewdestroy($id)
{
    $review = Review::findOrFail($id);

    if (!empty($review->review_image)) {
        $full = public_path($review->review_image);
        if (file_exists($full)) @unlink($full);
    }

    $review->delete();

    return response()->json(['ok' => true, 'message' => 'Deleted']);
}

}
