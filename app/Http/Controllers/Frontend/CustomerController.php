<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart\Cart;
use Illuminate\Http\Request;
use App\Models\Category\Category;
use App\Models\SubCategory\SubCategory;
use App\Models\Product\Product;
use App\Models\Customer\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerController extends Controller
{
    public function viewCustomerRegister() {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();

        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
         
        return view('frontend.auth.register',compact('carts','categories','subcategories','products'));
    }

    public function viewCustomerLogin() {
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        
        return view('frontend.auth.login',compact('carts','categories','subcategories','products'));
    }

    public function customerRegister(Request $request) {
        $validator = $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email',],
            'password' => ['required', Password::defaults()],
            'phone' => ['required','regex:/[0-9]{10}/'],
        ]);
        
        $customer = new Customer();
        
        $customer->name = $request['name'];
        $customer->password = Hash::make($request['password']);
        $customer->email = $request['email'];
        $customer->phone = $request['phone'];
        $customer->save();
        alert()->success('You have Successfully Registered');
        return back();
    }

    public function customerLogin(Request $request) {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required'
        ]);
        $remember_login = $request['remember'] == 'on' ? true : false;
        
        if (Auth::guard('customer')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $request->session()->regenerate();
            
            return redirect('/');
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors(['Either email address or password is incorrect.']);
    }

    public function logout(Request $request) {
        Auth::guard('customer')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return redirect('/');
    }
}
