<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use App\Models\Category\Category;
use App\Models\Customer\Customer;
use App\Models\Product\Product;
use App\Models\Setting\Setting;
use App\Models\SubCategory\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart(){
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        return view('frontend.customer.cart',compact('categories','subcategories','products','carts'));
    }

    public function addCart(Request $request){

        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => ['required', 'integer', 'gt:0']
        ]);

        $product=  Product::where('id', $request->product_id)->first();
        $keywords = explode(',', $product->keywords);
        if(!$product){
            return response()->json([
                'data' => Null,
                'status' => false,
                'message' => 'Product Not found'
            ]);
        }
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
        if (isset($carts)) {
            $carts->price = $product->price;
            $carts->quantity = $carts->quantity + $request->quantity;
            $carts->amount = $product->price * $carts->quantity;
            $carts->save();
        } else {
            $carts = new Cart;
            $carts->customer_id = Auth::guard('customer')->id();
            $carts->product_id = $product->id;
            $carts->price = $product->price;
            $carts->quantity = $request->quantity;
            $carts->amount = $carts->price * $carts->quantity;
            $carts->save();
        }
        $carts = Cart::where('customer_id', Auth::guard('customer')->id())->where('is_ordered', 0)->get();
        $total = 0;
        foreach($carts as $cart){
            $cartamount = $cart->amount;
            $total+= $cartamount;
        }

        return view('frontend.customer.cartproduct', compact('carts','total'))->render();

    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();

            request()->session()->flash('success', 'Cart successfully removed');

            return back()->with('message', 'Product has been removed from cart successfully.');
        }

        request()->session()->flash('error', 'Error please try again');

        return back();
    }

    public function update(Request $request) {

         foreach ($request->quantity as $key => $quantity) {
             $cart_id = $request->id[$key];
             $cart = Cart::find($cart_id);

             if ($quantity > 0 && $cart) {
                 $cart->quantity = $quantity;
                 $cart->price = $cart->product->price;
                 $cart->amount = $cart->price * $quantity;

                 $cart->save();
             }
         }

         return view('frontend.customer.cartupdate', compact('cart'))->render();
     }

     public function checkout() {
        if(Auth::guard('customer')->user() && isset(Auth::guard('customer')->user()->id)) {
            $categories = Category::get();
            $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
            $products = Product::where('is_featured', 1)->get();
            $customer_id = Auth::guard('customer')->id();
            $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

            $total = Cart::where('customer_id',  Auth::guard('customer')->user()->id)->where('is_ordered', 0)->sum(\DB::raw('amount'));
            $shipping_charge = Setting::where('slug','shipping_charge')->get();

            $total_amount = $total;


            return view('frontend.customer.checkout',compact('categories','subcategories','products','carts','total','total_amount'));
        } else {
            $customer_id = Auth::guard('customer')->id();
            $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
            $categories = Category::get();
            $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
            $products = Product::where('is_featured', 1)->get();

            return view('frontend.auth.login',compact('carts','categories','subcategories','products'));
        }

    }

}
