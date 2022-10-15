<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function orders()
    {
        $userrole = auth()->user()->role;
        if($userrole == 'admin'){
            $orders = Order::latest()->get();
            return view('admin.orders' ,compact('orders'));
        }
        return abort('403');
    }

    public function status(Order $order){

        if($order->status == "PENDING"){
            Order::find($order->id)->update([
                'status'    => 'APPROVED',
            ]);
            $order->orderproducts()->update([
                'status'    => 'APPROVED',
            ]);
        }

        if($order->status == "APPROVED"){
            Order::find($order->id)->update([
                'status'    => 'PENDING',
            ]);
            $order->orderproducts()->update([
                'status'    => 'PENDING',
            ]);
        }

        return response()->json(['success' => 'Updated Successfully.']);

    }

    public function sales_reports($filter){

        $userrole = auth()->user()->role;

        if($filter == 'daily'){
            $title_filter  = 'From: ' . date('F d, Y') . ' To: ' . date('F d, Y');
            $sales = OrderProduct::latest()->whereDate('created_at', Carbon::today())
                                ->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }
        elseif($filter == 'weekly'){
            $title_filter  = 'From: ' . Carbon::now()->startOfWeek()->format('F d, Y') . ' To: ' . Carbon::now()->endOfWeek()->format('F d, Y');
            $sales = OrderProduct::latest()->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }
        elseif($filter == 'monthly'){
            $title_filter  = 'From: ' . date('F '. 1 .', Y') . ' To: ' . date('F '. 31 .', Y');
            $sales = OrderProduct::latest()->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))
                                    ->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }
        elseif($filter == 'yearly'){
            $title_filter  = 'From: ' .'Jan 1'. date(', Y') . ' To: ' .'Dec 31'. date(', Y');
            $sales = OrderProduct::latest()->whereYear('created_at', '=', date('Y'))
                                    ->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }
        elseif($filter == 'all'){
            $title_filter  = 'ALL RECORDS';
            $sales = OrderProduct::latest()->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }else{
            $title_filter  = 'From: ' . date('F d, Y') . ' To: ' . date('F d, Y');
            $sales = OrderProduct::latest()->whereDate('created_at', Carbon::today())
                                    ->where('isCheckout', true)->where('status', 'APPROVED')->get();
        }

        return view('admin.sales_reports.sales_reports', compact('sales','title_filter'));
       
    }
    
}
