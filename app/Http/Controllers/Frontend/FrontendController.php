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
use App\Models\Customer\Customer;
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
            $allproductkeywords[$allproduct->title] = $allproduct->keywords;
        }
        foreach($allproductkeywords as $key => $allproductkeyword)
        {
            $allkeywords[$key] = explode(',', $allproductkeywords[$key]);
        }

        if (!is_array($allkeywords)) {
            return FALSE;
        }

        // Vector Space
        $vector1 = $customer_keywords ?? null;
        $recommendedProducts = $this->findRecommendedProducts($vector1, $allkeywords);
        if(!empty($recommendedProducts)) {
            $i = 0;
            foreach ($recommendedProducts as $recommendedProduct) {
                $customer_product_recommend[$i] = Product::where('title','LIKE','%'.$recommendedProduct['product'].'%')->first();
                $customer_product_recommend[$i]['jaccardIndex'] = $recommendedProduct['jaccardIndex'];
                $i++;
            }
        } else {
            $customer_product_recommend = null;
        }



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
        return view('frontend.home',compact('customer_product_recommend','carts','menus','sliders','brands','categories','subcategories','services','trainings','products','bestsellerproducts'));
    }

    // jaccardIndex
    // jaccardIndex
    public function findRecommendedProducts($productName, $products, $numProducts = 8) {
        $recommendedProducts = array();

        foreach ($products as $otherProductName => $otherProductKeywords) {
            foreach($productName as $customer_keywords){
                if ($customer_keywords != $otherProductName) {
                    $keywords[] = $customer_keywords;
                    $jaccardIndex = $this->jaccardIndex($keywords, $otherProductKeywords);
                    if ($jaccardIndex > 0 && $jaccardIndex < 1) {
                      $recommendedProducts[] = array('product' => $otherProductName, 'jaccardIndex' => $jaccardIndex);
                    }
                }
            }
        }
        usort($recommendedProducts, function($a, $b) {
          return $b['jaccardIndex'] <=> $a['jaccardIndex'];
        });

        $tempArr = array_unique(array_column($recommendedProducts, 'product'));
        $recommendedProducts = array_intersect_key($recommendedProducts, $tempArr);

        return array_slice($recommendedProducts, 0, $numProducts);
    }


    public function jaccardIndex($set1, $set2) {
        $intersection = count(array_intersect($set1, $set2));
        $union = count(array_unique(array_merge($set1, $set2)));
        return $intersection / $union;
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

    public function listAllProduct(Request $request)
    {

        $brands = Brand::get();
        if($request->has('option')){
            if ($request->option == 'name') {
                $product = Product::orderBy('title','asc')->paginate(15);
            }
            elseif($request->option == 'price-low-to-high') {
                $product = Product::orderBy('price','asc')->paginate(15);
            }
            elseif ($request->option == 'price-high-to-low') {
                $product = Product::orderBy('price','desc')->paginate(15);

            }
        }else{
            $product = Product::paginate(15);
        }

        $categories = Category::get();
        $subcategories = SubCategory::where('is_published', 1)->get();
        $products = Product::paginate(15);
        $customer_id = Auth::guard('customer')->id();
        $carts = Cart::where('customer_id', $customer_id)->where('is_ordered', 0)->get();
        return view('frontend.product.list_all_product', compact('carts','brands','products','categories','subcategories'));
    }

    public function applyFilter(Request $request)
    {
        $products = Product::where(function ($query) use ($request) {
                if (!empty($request->min) || !empty($request->max)) {
                    $query->where('price', '>=',  $request->min)->where('price', '<=',  $request->max);
                }
                if (!empty($request->brand)) {
                    $query->whereIn('brand_id', $request->brand);
                }
                if (!empty($request->category)) {
                    $query->whereIn('category_id', $request->category);
                }
                if (!empty($request->stock)) {
                    $query->where('stock', 'LIKE', '%' . $request->stock . '%');
                }
                return $query;
            });
            if(!empty($request->filter)) {
                if($request->filter == "high") {
                    $products->orderByDesc('price');
                }
                if($request->filter == "name") {
                    $products->orderBy('title');
                }
                if($request->filter == "low") {
                    $products->orderBy('price');
                }
                if($request->filter == "new") {
                    $products->orderByDesc('created_at');
                }
            }
            $products = $products->get();

        return view('frontend.product.productrender',compact('products'))->render();
    }

    public function getproductbyCategory($slug, Request $request)
    {
        $category = Category::where('slug',$slug)->first();
        $subcategory = SubCategory::where('id', $category->id)->get();
        $brands = Brand::get();
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
        return view('frontend.product.productcategory', compact('carts','brands','products','product','category','categories','subcategory','subcategories'));
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
                        ->orWhere('description','LIKE',"%".$request->keyword."%")
                        ->orWhere('keywords','LIKE','%'.$request->keyword.'%')->get();
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
