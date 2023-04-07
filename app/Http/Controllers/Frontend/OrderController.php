<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Category\Category;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\OrderDetail\OrderDetail;
use App\Models\Product\Product;
use App\Models\Setting\Setting;
use App\Models\SubCategory\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;

class OrderController extends Controller
{


    public function store(Request $request){

        $this->validate($request, [
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
            'preferred_delivery_date' => ['required'],
            'payment_method' => ['required'],

        ]);
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        if (count($carts) == 0) {
            request()->session()->flash('error', 'Cart is Empty !');

            return back();
        }

        $order_number_generated = null;

        do {
            $order_number_generated = 'ORD-' . strtoupper(Str::random(10));
        } while (Order::where("order_number", $order_number_generated)->first());

        $total = Cart::where('customer_id',  Auth::guard('customer')->user()->id)->where('is_ordered', 0)->sum(\DB::raw('amount'));

        $total_amount = $total;

        $order = new Order;
        $order->order_number = $order_number_generated;
        $order->customer_id = $customer_id;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->order_note = $request->order_note;
        $order->shipping_charge = 0;
        $order->preferred_delivery_date = $request->preferred_delivery_date;
        $order->timeslot = $request->timeslot;
        $order->total_amount = $total_amount;
        $order->payment_method = $request->payment_method;
        $order->payment_status = "unpaid";
        $order->status = "new";
        $order->save();

        //create order details
        foreach($carts as $cart) {
            $order_details = new OrderDetail();
            $order_details->order_id = $order->id;
            $order_details->product_id = $cart->product_id;
            $order_details->name = $cart->product->title;
            $order_details->rate = $cart->price;
            $order_details->quantity = $cart->quantity;
            $order_details->amount = $cart->amount;

            $product=  Product::where('id', $cart->product_id)->first();
            $keywords = explode(',', $product->keywords);
            $carts = Cart::where('customer_id', Auth::guard('customer')->id())->where('is_ordered', 0)->where('product_id', $product->id)->first();
            $customer = Customer::where('id',Auth::guard('customer')->id())->first();
            if($customer) {
                foreach($keywords as $keyword)
                {
                    if(str_contains($customer->keywords, $keyword))
                    {
                    break;
                    } else {
                        if(!empty($customer->keywords)) {
                            $customer->keywords = $customer->keywords. ',' .$keyword;
                        } else {
                            $customer->keywords = $keyword;
                        }
                        $customer->save();
                    }
                }

            }

            //dd($request->all());
            $order_details->save();

            // Mark Cart as Ordered
            $cart->is_ordered = 1;
            $cart->save();
        }
        return redirect()->route('order-details', $order->order_number)->with('status', 'success');

    }

    public function orderDetails($order_number) {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        $order_details = Order::where('order_number', $order_number)->first();
        $order_items = OrderDetail::where('order_id',$order_details->id)->get();
        return view('frontend.customer.order-details',compact('order_details','order_items','carts','categories','subcategories','products'));
    }

    public function viewOrder()
    {
        $orders = Order::orderBy('id', 'DESC')->get();

        return view('backend.order.index',compact('orders'));

    }

    public function updatePaymentStatus(Request $request){

        foreach($request->order_id as $order){
            $list= Order::where('id',$order)->first();
            $list->payment_status = $request->paymentstatus;
            $list->status = $request->status;
            $list->save();
       }
       return response()->json([
           'status' => true,
           'message' => "Payment Status Updated"
       ]);
    }

    public function viewOrderItems(Request $request)
    {
        $order_items = OrderDetail::where('order_id',$request->order_id)->get();
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => $order_items
        ]);
    }
}
