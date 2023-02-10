<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\OrderProduct;
use App\Models\Order;
use App\Models\ProductSizePrice;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailNotification;


class OrderController extends Controller
{
    public function view(Product $product){
        $regular_price = $product->retailed_price;
        if($product->expiration < Carbon::now()->addMonths(3)){
            $discount_percentage = .45;
            $promo = "3";
        }
        
        if($product->expiration < Carbon::now()->addMonths(2)){
            $discount_percentage = .35;
            $promo = "2";
        }
        
        if($product->expiration < Carbon::now()->addMonths(1)){
            $discount_percentage = .25;
            $promo = "1";
        }

        if($product->expiration > Carbon::now()->addMonths(3)){
            $discount_percentage = 0;
            $promo = "0";

        }
        $discounted = $regular_price * $discount_percentage;

        

        $product_d = [
            'name'         => $product->name,
            'category'     => $product->category->name,
            'image'        => $product->image,
            'stock'        => 'Stock: '. $product->stock,
            'price'        => 'Price: ₱ '. $product->retailed_price,
            'description'  => $product->description ?? '',
            'expiration'  => 'Expiration: ₱ '.$product->expiration->format('M j , Y'),
            'exp'        => $promo ?? '',
            'isStar'     => $product->reviewsIsStar(),
            'discounted'    => '('.'Less '. $discounted .')',
        ];

        $reviews = Review::where('product_id', $product->id)
                            ->latest()
                            ->get();

        foreach($reviews as $review){
            $reviews1[] = array(
                'name'              => $review->user->name, 
                'review'            => $review->review,
                'isStar'            => $review->isStar,
                'date_time'         => $review->created_at->diffForHumans(),
            );
        }

        return response()->json([
            'product'      =>  $product_d,
            'reviews'  => $reviews1 ?? '',
        ]);

    }

    public function order(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'qty'  => ['required' ,'integer','min:1'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }


        $regular_price = $product->retailed_price;
        if($product->expiration < Carbon::now()->addMonths(3)){
            $discount_percentage = .25;
            $promo = "25 % OFF";
        }
        
        if($product->expiration < Carbon::now()->addMonths(2)){
            $discount_percentage = .35;
            $promo = "35 % OFF";
        }
        
        if($product->expiration < Carbon::now()->addMonths(1)){
            $discount_percentage = .45;
            $promo = "45 % OFF";
        }

        if($product->expiration > Carbon::now()->addMonths(3)){
            $discount_percentage = 0;
            $promo = "";
        }
        $discounted = $regular_price * $discount_percentage;
        $price_discounted = $regular_price - $discounted;

        if($request->input('qty') > $product->stock){
            return response()->json(['errorstock' => 'Must be less than the stock.']);
        }
                        
        $amount = $price_discounted * $request->input('qty');
        $total_discounted = $discounted * $request->input('qty');

        OrderProduct::updateOrcreate(
            [
                'user_id'    => auth()->user()->id,
                'product_id' => $product->id,
                'isCheckout' => false,
            ],
            [
                'user_id'    => auth()->user()->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'expiration'    => $product->expiration,
                'qty'        => $request->input('qty'),
                'amount'     => $amount,
                'price'      => $price_discounted,
                'promo'    => $promo,
                'discounted'    => $total_discounted,
            ]
        );

        return response()->json(['success' => 'Ordered Successfully.']);
    }

    public function orders(){
        date_default_timezone_set('Asia/Manila');
        $orders = OrderProduct::where('user_id', auth()->user()->id)
                                 ->where('isCheckout', false)
                                 ->latest()
                                 ->get();

        return view('customer.orders',compact('orders'));
    }
    public function edit(OrderProduct $order){
        $orders = [
            'name'         => $order->product->name,
            'category'     => $order->product->category->name,
            'image'        => $order->product->image,
            'qty'          => $order->qty,
            'stock'        => 'Stock: '. $order->product->stock,
            'price'        => 'Price: ₱ '. $order->price,
            'description'  =>  $order->product->description ?? '',
            'promo'          => $order->promo ?? '',
            'discounted'      => 'Discounted: ₱ '. $order->discounted,
            'expiration'  => 'Expiration: ₱ '.$order->product->expiration->format('M j , Y'),
        ];

        return response()->json([
            'order'      =>  $orders,
        ]);

    }

    public function update(Request $request, OrderProduct $order)
    {
        date_default_timezone_set('Asia/Manila');
        $validated =  Validator::make($request->all(), [
            'qty'  => ['required' ,'integer','min:1'],
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        }


        if($request->input('qty') > $order->product->stock){
            return response()->json(['errorstock' => 'Must be less than the stock.']);
        }

        $regular_price = $order->product->retailed_price;
        if($order->product->expiration < Carbon::now()->addMonths(3)){
            $discount_percentage = .25;
            $promo = "25 % OFF";
        }
        
        if($order->product->expiration < Carbon::now()->addMonths(2)){
            $discount_percentage = .35;
            $promo = "35 % OFF";
        }
        
        if($order->product->expiration < Carbon::now()->addMonths(1)){
            $discount_percentage = .45;
            $promo = "45 % OFF";
        }

        if($order->product->expiration > Carbon::now()->addMonths(3)){
            $discount_percentage = 0;
            $promo = "";
        }
        $discounted = $regular_price * $discount_percentage;
        $price_discounted = $regular_price - $discounted;

        $amount = $price_discounted * $request->input('qty');
        $total_discounted = $discounted * $request->input('qty');
    
        OrderProduct::find($order->id)->update(
            [
                'qty'        => $request->input('qty'),
                'amount'     => $amount,
                'price'      => $price_discounted,
                'promo'    => $promo,
                'discounted'    => $total_discounted,
            ]
        );

        return response()->json(['success' => 'Ordered Updated Successfully.']);
    }

    public function cancel(OrderProduct $order){
        $order->delete();
        return response()->json(['success' => 'Ordered Canceled Successfully.']);
    }

    public function checkout(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $orderproducts = OrderProduct::where('user_id', auth()->user()->id)
                            ->where('isCheckout', false)->get();

        $ordercount = OrderProduct::where('user_id', auth()->user()->id)
                                    ->where('isCheckout', false)->count();

        if($ordercount < 1){
            return response()->json(['nodata' => 'No data available']);
        } 
        if(auth()->user()->address == null){
            return response()->json(['no_address' => 'No address indicated in this account .']);
        }
        
        

        $orders = Order::create([
            'user_id'   => auth()->user()->id,
            'shipping_option' => $request->get('shipping')
        ]);
        foreach($orderproducts as $order){
            if($order->qty > $order->product->stock){
                Order::find($orders->id)->delete();
                return response()->json(['no_stock' => 'Out of stock <br>
                                                        Product: '.$order->product->name.
                                                        '<br> Qty: '.$order->qty. 
                                                        '<br> Available Stock: '.$order->product->stock]);
            }else{
                Product::where('id', $order->product_id)->decrement('stock', $order->qty);
                OrderProduct::where('id', $order->id)
                                ->update([
                                    'order_id' => $orders->id,
                                    'isCheckout' => true,
                                ]);
            }
        }

        $emailNotif = [
            'msg'              => "SUCCESSFULLY CHECKOUT YOUR ORDERS",
            'name'              =>  $orders->user->name,
            'address'              =>  $orders->user->address,
            'contact_number'              =>  $orders->user->contact_number,
            'email'              =>  $orders->user->email,

            'order_number'     => $orders->id,
            'placed_on'         =>  $orders->created_at->format('M j , Y h:i A') ,
            'delivery'  => "Delivery date Expect 3-5 working days",
            'total' => number_format($orders->orderproducts->sum('amount')),
        ];  

        Mail::to($orders->user->email)
        ->send(new EmailNotification($emailNotif));

        return response()->json(['success' => 'Ordered Successfully Checkout.']);
        
    }
    
    public function orders_history(){
        $orders = Order::where('user_id', auth()->user()->id)
                            ->where('status', "PENDING")->latest()->get();
        $orders_approved = Order::where('user_id', auth()->user()->id)
                            ->where('status', "APPROVED")->latest()->get();

        return view('customer.orders_history' ,compact('orders' , 'orders_approved'));
    }
    public function cancel_order(Order $order){
        Order::find($order->id)
            ->update([
                'status'    => 'CANCELLED'
            ]);

        foreach($order->orderproducts()->get() as $order_p){
            if($order_p->product->expiration < Carbon::now()->addMonths(3)){
                $order_qty = $order_p->qty * 2;
                Product::where('id', $order_p->product->id)
                    ->increment('stock', $order_qty );
            }else{
                Product::where('id', $order_p->product->id)
                    ->increment('stock', $order_p->qty);
            }
        }

        $order->orderproducts()->update([
            'status'    => 'CANCELLED',
        ]);


        return response()->json(['success' => 'Successfully Cancelled.']);
    }
    
   
}
