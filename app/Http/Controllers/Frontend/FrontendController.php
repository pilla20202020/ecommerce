<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu\Menu;
use App\Models\Menu\SubMenu;
use App\Models\Page\Page;
use App\Models\Slider\Slider;
use App\Models\Brand\Brand;
use App\Models\Category\Category;
use App\Models\SubCategory\SubCategory;
use App\Models\Product\Product;
use App\Models\Service\Service;
use App\Models\Training\Training;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMailNotifiable;
use App\Mail\SendContactInfo;
use App\Models\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homepage()
    {
        $menus = Menu::where('is_published',0)->get();
        $sliders = Slider::where('is_published',0)->get();
        $brands = Brand::where('is_featured', 1)->where('is_published', 1)->get();
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $bestsellerproducts = Product::where('best_seller', 1)->get();
        $services = Service::where('is_featured', 1)->where('is_published', 1)->get();
        $trainings = Training::where('is_featured', 1)->where('is_published', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        return view('frontend.home',compact('carts','menus','sliders','brands','categories','subcategories','services','trainings','products','bestsellerproducts'));
    }

    
    

    public function services()
    {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        
        $trainings = Training::where('is_featured', 1)->where('is_published', 1)->get();
        return view('frontend.service.index',compact('carts','trainings','categories','subcategories','products'));
    }

    public function trainingsDetail(Training $trainings){
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        $services = Service::where('is_featured', 1)->where('is_published', 1)->get();
        return view('frontend.service.detail',compact('carts','trainings','services','categories','subcategories','products'));
    }
    
    public function contact()
    {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        return view('frontend.contact.contact',compact('carts','categories','subcategories','products'));
    }

    

    public function sendcontact(Request $request)
    {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        $data = $request->all();
        Mail::to('ritu.gubhaju20@gmail.com')->send(new SendContactInfo($data));
        return redirect()->back()->withSuccess(trans('Contact Inquiry Send Successfully'));
    }

    public function getproductbyCategory($slug, Request $request)
    {
        $category = Category::where('slug',$slug)->first();   
        $subcategory = SubCategory::where('id', $category->id)->get();
        if($request->has('option')){
            if ($request->option == 'name') {
                $product = Product::where('category_id',$category->id)->orderBy('title','asc')->paginate(15);
            }
            elseif($request->option == 'price-low-to-high') {
                $product = Product::where('category_id',$category->id)->orderBy('price','asc')->paginate(15);
            }
            elseif ($request->option == 'price-high-to-low') {
                $product = Product::where('category_id',$category->id)->orderBy('price','desc')->paginate(15);
           
            }
        }else{
            $product = Product::where('category_id',$category->id)->paginate(15);
        }
        
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        return view('frontend.product.productcategory', compact('carts','products','product','category','categories','subcategory','subcategories'));
    }

    public function getproductbySubCategory($slug , Request $request)
    {
        $category = Category::where('id',$slug)->first();
        $subcategory = SubCategory::where('slug', $slug)->first();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        if($request->has('option')){
            if ($request->option == 'name') {
                $product = Product::where('subcategory_id',$subcategory->id)->orderBy('title','asc')->paginate(15);
            }
            elseif($request->option == 'price-low-to-high') {
                $product = Product::where('subcategory_id',$subcategory->id)->orderBy('price','asc')->paginate(15);
            }
            elseif ($request->option == 'price-high-to-low') {
                $product = Product::where('subcategory_id',$subcategory->id)->orderBy('price','desc')->paginate(15);
           
            }
        }else{
            $product = Product::where('subcategory_id',$subcategory->id)->paginate(15);
        }
       

        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();   
        $products = Product::where('is_featured', 1)->get();
       
        return view('frontend.product.productsubcategory', compact('carts','products','product','category','categories','subcategory','subcategories'));
    }

    public function productdetailbyCategory(Product $products)
    {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('slug',$products->slug)->first();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        return view('frontend.product.productcategorydetail', compact('carts','products','categories','subcategories'));
    }

    


    public function quickViewProduct(Request $request){
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        
        
        $product_id = $request->get('product_id');
        if($product_id){
            $product = Product::find($request->product_id);
            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $product
            ]);
        } else
        {
            return response()->json([
                'status' => false,
                'message' => 'No Such Product',
                'data' => NULL
            ]);

        }
    }

    public function about()
    {
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();

        return view('frontend.about.about',compact('carts','categories','subcategories','products'));
    }

    public function searchResult(Request $request){
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        
        $search_title = $request->keyword;
        if(isset($request->keyword) && !empty($request->keyword)){
    
            $product = Product::where('title','LIKE',"%".$request->keyword."%")
                        ->orWhere('description','LIKE',"%".$request->keyword."%")->get();
            return view('frontend.product.productsearch', compact('carts','categories','subcategories','products','product','search_title'));
        }
        
    }

    public function page($slug = null)
    {
        
        $categories = Category::get();
        $subcategories = SubCategory::where('is_featured', 1)->where('is_published', 1)->get();
        $products = Product::where('is_featured', 1)->get();
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
       
        if ($slug) {
            
            $page = Page::whereSlug($slug)->whereIsPublished(1)->first();
            

            if ($page == null) {
    
                return view('frontend.errors.404',compact('categories','subcategories','products'));
            }

            if ($page) {
                $pages = Page::whereIsPublished(1)->whereIsPrimary(0)->whereNotIn('id', [$page->id])->take(10)->inRandomOrder()->get();
                if ($pages) {
                    return view('frontend.page', compact('page', 'pages','categories','subcategories','products'));
                }
            } else {
                return view('frontend.errors.404',compact('carts','categories','subcategories','products'));
            }
        }
    }
   
}
