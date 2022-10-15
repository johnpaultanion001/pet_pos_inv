<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Carbon\Carbon;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){

            $products = Product::latest()->get();
            $products_today = Product::whereDay('created_at', '=', date('d'))->get();

            $customers = User::where('role', 'customer')->get();
            $customers_today = User::where('role', 'customer')->whereDay('created_at', '=', date('d'))->get();

            $orders = Order::latest()->get();
            $orders_today = Order::whereDay('created_at', '=', date('d'))->get();

            $sales = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->sum('amount');
            $sales_today = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->whereDay('created_at', '=', date('d'))->sum('amount');
            
            $product_exp = Product::where("expiration","<", Carbon::now()->addMonths(3))->get();
            $exp_label  = 'From: ' . date('F d, Y') . ' To: ' . Carbon::now()->addMonths(3)->format('F d, Y');

            return view('admin.home', compact('products','products_today','customers','customers_today', 'orders','orders_today','sales','sales_today','product_exp','exp_label'));
        }
        return abort('403');
    }
}
