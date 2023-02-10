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

            $status_approved = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->get()->count();
            $status_pending = OrderProduct::where('isCheckout', '1')->where('status','PENDING')->get()->count();

           $monthlySales  = OrderProduct::where('isCheckout','1')->where('status','APPROVED')->selectRaw('sum(amount) as total_sales, month(created_at) as month, year(created_at) as year')
            ->groupBy('month', 'year')
            ->get();

            

            
            $labels = $monthlySales->pluck('month')->toArray();
            $data = $monthlySales->pluck('total_sales')->toArray();

            $sales = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->sum('amount');
            $sales_today = OrderProduct::where('isCheckout', '1')->where('status','APPROVED')->whereDay('created_at', '=', date('d'))->sum('amount');
            
            $product_exp = Product::where("expiration","<", Carbon::now()->addMonths(3))->get();
            $exp_label  = 'From: ' . date('F d, Y') . ' To: ' . Carbon::now()->addMonths(3)->format('F d, Y');

            $lower_stock  = Product::where("stock","<", 6)->get();


            // SOLD CHART
            $recordSolds  = OrderProduct::where('isCheckout','1')
            ->where('status','APPROVED')
            ->selectRaw('sum(qty) as sold, product_name as product, product_id as productId')
            ->groupBy('productId','product')
            ->get();

            $labels_sold = $recordSolds->pluck('product')->toArray();
            $data_sold = $recordSolds->pluck('sold')->toArray();

            

            $labels_sold = $recordSolds->pluck('product')->toArray();
            $data_sold = $recordSolds->pluck('sold')->toArray();

            return view('admin.home', compact('labels','data','products','products_today','customers','customers_today', 'orders','status_approved','status_pending','orders_today','sales','sales_today','product_exp','exp_label','lower_stock','labels_sold','data_sold'));
        }
        return abort('403');
    }
}
