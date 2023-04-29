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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart(){
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        $customer = Customer::where('id',Auth::guard('customer')->id())->first();
        if($customer) {
            $customer_keywords = explode(',', $customer->keywords);
            if($customer_keywords[0] != "") {
                $customer_keywords = array_reverse($customer_keywords);
                foreach($customer_keywords as $key => $keyword)
                {
                    $recommend_product[$key] = Product::where('keywords','LIKE','%'.$keyword.'%')->get()->toArray();
                }
                $singleArrayForCategory = array_reduce($recommend_product, 'array_merge', array());
                $customer_recommend_product = array_map("unserialize", array_unique(array_map("serialize", $singleArrayForCategory)));
            } else {
                $customer_recommend_product = null;
            }
        } else {
            $customer_recommend_product = null;
        }

        $allproducts =  Product::get();
        foreach($allproducts as $allproduct)
        {
            $allproductkeywords[] = $allproduct->keywords;
        }
        
        // dd($allproductkeywords, explode(',', $allproductkeywords[0]));
        foreach($allproductkeywords as $key => $allproductkeyword)
        {
            $allkeywords[] = explode(',', $allproductkeywords[$key]);
        }
        
        if (!is_array($allkeywords)) { 
            return FALSE; 
        } 
        $result = array(); 
        foreach ($allkeywords as $key => $value) { 
            if (is_array($value)) { 
            $result = array_merge($result, $value); 
            } 
            else { 
            $result[$key] = $value; 
            } 
        } 
        
        // Vector Space
        $vector1 = $customer_keywords ?? null;
        $vector2 = $allproductkeywords ?? null;
        // dd($vector1, $vector2);
        foreach($vector2 as $key => $vec2) {
            // dd($value);
            $vector2_string = $vec2;
            $asciiValues_vector2 = [];
            for ($i = 0; $i < strlen($vector2_string); $i++) {
                $asciiValues_vector2[] += ord($vector2_string[$i]);
            }
        }
        // dd($vector1);
        // rsort($asciiValues_vector2);
        foreach($vector1 as $key => $vec1) {
            
            $vector1_string = $vec1;
            
            $asciiValues_vector1 = [];
            for ($i = 0; $i <= $key; $i++) {
                $asciiValues_vector1[] += ord($vector1_string[$i]);
            }
        }
        rsort($asciiValues_vector1);
        
        
        // dd($asciiValues_vector1, $asciiValues_vector2);
        if(!empty($asciiValues_vector1)) {
            foreach($asciiValues_vector1 as $key => $value){
                if(isset($asciiValues_vector2[$key])){
                    $similarity_score[] =  $this->cosine_similarity($value, $asciiValues_vector2);
                }
            }
            // dd($similarity_score);
            rsort($similarity_score);
        } else {
            $similarity_score = null;
        }
        // dd($similarity_score, $customer_keywords, $customer_recommend_product);
        // $string = "tshirt,Shirt for men,men's shirt";
        // $asciiValues = 0;
        // for ($i = 0; $i < strlen($string); $i++) {
        //     $asciiValues += ord($string[$i]);
        // }

        // dd($asciiValues);
        return view('frontend.customer.cart',compact('customer_recommend_product','categories','subcategories','products','carts','similarity_score'));
    }

    // cosine similarity
    public function cosine_similarity($vector1, $vector2) {
        
        $dot_product = 0.0;
        $magnitude1 = 0.0;
        $magnitude2 = 0.0;
        $dot_product += ($vector1 * $vector2[0]) ;
        $magnitude1 += pow($vector1, 2);
        // $magnitude2 += pow($vector2, 2);
        // foreach($vector1 as $key => $value) {
        //     if(isset($vector2[$key])) {
        //         $dot_product += ($value * $vector2[$key]);
        //     }
        //     $magnitude1 += pow($value, 2);
        // }
        
        foreach($vector2 as $key => $value) {
            $magnitude2 += pow($value, 2);
        }
        
        $magnitude = sqrt($magnitude1) * sqrt($magnitude2);
        
        // dd($dot_product, $magnitude1, $magnitude2, $magnitude);

        if($magnitude == 0.0) {
            return 0.0;
        }

        return $dot_product / $magnitude;
    }

    public function addCart(Request $request){

        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => ['required', 'integer', 'gt:0']
        ]);

        $product=  Product::where('id', $request->product_id)->first();
        if(!$product){
            return response()->json([
                'data' => Null,
                'status' => false,
                'message' => 'Product Not found'
            ]);
        }
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

            $customer = Customer::where('id',Auth::guard('customer')->id())->first();
            if($customer) {
                $customer_keywords = explode(',', $customer->keywords);
                if($customer_keywords[0] != "") {
                    $customer_keywords = array_reverse($customer_keywords);
                    foreach($customer_keywords as $key => $keyword)
                    {
                        $recommend_product[$key] = Product::where('keywords','LIKE','%'.$keyword.'%')->get()->toArray();
                    }
                    $singleArrayForCategory = array_reduce($recommend_product, 'array_merge', array());
                    $customer_recommend_product = array_map("unserialize", array_unique(array_map("serialize", $singleArrayForCategory)));
                } else {
                    $customer_recommend_product = null;
                }
            } else {
                $customer_recommend_product = null;
            }


            return view('frontend.customer.checkout',compact('customer_recommend_product','categories','subcategories','products','carts','total','total_amount'));
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
