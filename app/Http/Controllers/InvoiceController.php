<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Include_;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function InvoiceAll()
    {
        $allData =Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('admin.backend.invoice.invoice-all', compact('allData'));
    }
    public function InvoicePendingList()
    {
        $allData =Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status','0')->get();
        return view('admin.backend.invoice.invoice-pending-list', compact('allData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function InvoiceAdd()
    {
        $category  = Category::all();
        $customers = Customer::all();

        $invoice_no = 'INV-' . now()->format('YmdHis') . '-' . random_int(100, 999); // ✅ unique-ish
        $date = now()->toDateString();

        return view('admin.backend.invoice.invoice-add', compact('invoice_no', 'category', 'date', 'customers'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function InvoiceStore(Request $request)
    {
        // dd($request->all());
        if($request->category_id == null){

            $notification = array(
                'message' => 'Sorry  you do not select any item',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);

        }else{
            if($request->paid_amount > $request->estimated_amount){
                $notification = array(
                    'message' => 'Sorry paid amount is maximum the total price',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }else{
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function() use($request, $invoice){
                    if($invoice->save()){
                        $count_category = count($request->category_id);
                        for($i = 0; $i < $count_category; $i++){
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $invoice_details->invoice_id =  $invoice->id;
                            $invoice_details->category_id =  $request->category_id[$i];
                            $invoice_details->product_id =  $request->product_id[$i];
                            $invoice_details->selling_qty =  $request->selling_qty[$i];
                            $invoice_details->unit_price =  $request->unit_price[$i];
                            $invoice_details->selling_price =  $request->selling_price[$i];
                            $invoice_details->status =  '0';
                            $invoice_details->save();
                        }
                        if($request->customer_id == '0'){
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->email = $request->email;
                            $customer->created_by = Auth::user()->id;
                            $customer->save();
                            $customer_id = $customer->id;
                        }else{
                            $customer_id = $request->customer_id;
                        }
                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if($request->paid_status == 'full_paid'){
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        }elseif($request->paid_status == 'full_due'){
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';

                        }elseif($request->paid_status == 'partial_paid'){
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->save();
                    }
                });
            }
        }
        $notification = array(
            'message' => 'Invoice data insert successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending.list')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function InvoiceDelete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();

        $notification = array(
            'message' => 'Invoice delete successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function InvoiceApprove($id){
        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        // dd($invoice);
        return view('admin.backend.invoice.invoice-approve', compact('invoice'));
    }
    public function ApproveStore(Request $request, $id){
        foreach($request->selling_qty as $key => $value){
            $invoice_details = InvoiceDetail::where('id', $key)->first();

            $invoice_details->status = '1';
            $invoice_details->save();

            $product = Product::where('id', $invoice_details->product_id)->first();
            if($product->quantity < $request->selling_qty[$key]){
                $notification = array(
                    'message' => 'Sorry you have to Maximum Value',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }
        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function() use($request, $invoice, $id){
            foreach($request->selling_qty as $key => $val){
                $invoice_details = InvoiceDetail::where('id',$key)->first();
                $product = Product::where('id',$invoice_details->product_id)->first();
                $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
                $product->save();
            }
            $invoice->save();
        });
        $notification = array(
            'message' => 'Invoice Approve Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending.list')->with($notification);
    }

    public function PrintInvoiceList(){
        $allData =Invoice::orderBy('date', 'desc')->orderBy('id', 'desc')->where('status', '1')->get();
        return view('admin.backend.invoice.print-invoice-list', compact('allData'));
    }
    public function PrintInvoice($id){
        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        // dd($invoice);
        return view('admin.backend.pdf.invoice-pdf', compact('invoice'));
    }
    public function DailyInvoiceReport(){
        // $invoice = Invoice::with('invoice_details')->findOrFail($id);

        return view('admin.backend.invoice.daily-invoice-report');
    }
    public function DailyInvoicePdf(Request $request){
        $sdate = date('Y-m-d', strtotime($request->start_date));
        $edate = date('Y-m-d', strtotime($request->end_date));
        $allData = Invoice::whereBetween('date', [$sdate, $edate])->where('status', '1')->get();

        $start_date = date('Y-m-d', strtotime($request->start_date));
        $end_date = date('Y-m-d', strtotime($request->end_date));
        return view('admin.backend.pdf.daily-invoice-report-pdf', compact('allData','start_date','end_date'));
    }

    public function adminPaid(Request $request, Invoice $invoice)
    {
        DB::transaction(function () use ($invoice) {

            $payment = $invoice->payment; // relation: payment()

            if (!$payment) {
                abort(404, 'Payment record not found for this invoice.');
            }

            // আগে due কত ছিল সেটাই "এখন paid" হবে
            $dueBefore = (float) $payment->due_amount;

            // যদি আগে থেকেই paid থাকে / due 0 হয়
            if ($dueBefore <= 0) {
                return;
            }

            // ✅ payment_details এ entry
            PaymentDetail::create([
                'invoice_id'          => $invoice->id,
                'current_paid_amount' => $dueBefore,
                'date'                => now()->toDateString(),
                'updated_by'          => Auth::id(), // admin/user id
            ]);

            // ✅ payments আপডেট
            $payment->paid_amount = (float)$payment->paid_amount + $dueBefore;
            $payment->due_amount  = 0;
            $payment->paid_status = 'paid';
            $payment->save();
        });

        return redirect()->back()->with('success', 'Payment marked as paid!');
    }
    public function updateStatus(Request $request, Invoice $invoice)
    {
        // dd('ok', $invoice);
        $request->validate([
            'order_status' => 'required|in:1,2,3,4,5',
        ]);

        $invoice->order_status = (int) $request->order_status;
        $invoice->save();

        return response()->json([
            'success' => true,
            'message' => 'Invoice status updated successfully',
            'status'  => $invoice->order_status,
        ]);
    }
}
