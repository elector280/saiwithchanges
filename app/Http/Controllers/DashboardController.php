<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function Dashboard(){
        $user = Auth::user();

        if ($user->type == 'user') {
           return redirect()->route('customer.dashboard');
        }else{
            $total_sales = DB::table('invoices')->count();
            $total_purchases = DB::table('purchases')->count();
            $suppliers = DB::table('suppliers')->count();
            $customers = DB::table('customers')->count();
            return view('admin.index', compact('total_sales', 'total_purchases', 'suppliers', 'customers'));
        }

        return redirect()->route('customer.login');
    }
}
