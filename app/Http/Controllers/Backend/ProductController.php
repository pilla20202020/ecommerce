<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Category\Category;
use App\Models\Brand\Brand;
use App\Models\Product\Product;
use App\Models\SubCategory\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $category;

    function __construct(Category $category, Product $product, SubCategory $subcategory , Brand $brand)
    {
        $this->category = $category;
        $this->subcategory = $subcategory;
        $this->brand = $brand;
        $this->product = $product;


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = $this->product->orderBy('created_at', 'desc')->get();
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = $this->category->get();
        $subcategories = $this->subcategory->get();
        $brands = $this->brand->get();
        return view('backend.product.create',compact('categories','subcategories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title'      => 'required|max:255',
            'image' => 'required',
            'stock' => 'required',
        ]);
        if ($product = $this->product->create($request->data())) {

            if ($request->hasFile('image')) {
                $this->uploadFile($request, $product, 'image');
            }
            if ($request->hasFile('banner_image')) {
                $this->uploadFile($request, $product, 'banner_image');
            }
            if ($request->hasFile('image1')) {
                $this->uploadFile($request, $product, 'image1');
            }
            if ($request->hasFile('image2')) {
                $this->uploadFile($request, $product, 'image2');
            }

        return redirect()->route('product.index')->withSuccess(trans('New Subcategory has been created'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        $category_search = $this->category->find($product->category_id);
        $subcategory_search = $this->subcategory->find($product->subcategory_id);
        return view('backend.product.show', compact('product','category_search','subcategory_search'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
        $category_search = $this->category->find($product->category_id);
        $categories = $this->category->get();
        $subcategory_search = $this->subcategory->find($product->subcategory_id);
        $subcategories = $this->subcategory->get();
        $brand_search = $this->brand->find($product->brand_id);
        $brands = $this->brand->get();
        $keywords = explode(',', $product->keywords);
        return view('backend.product.edit', compact('product','keywords','category_search','categories','subcategory_search','subcategories','brand_search','brands'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'title'      => 'required|max:255',
            'stock'      => 'required|max:255',
        ]);
        if ($product->update($request->data())) {
            $product->fill([
                'slug' => Str::slug($request->title),
            ])->save();
            if ($request->hasFile('image')) {


                $this->uploadFile($request, $product, 'image');
            }
            if ($request->hasFile('banner_image')) {
                $this->uploadFile($request, $product, 'banner_image');
            }
            if ($request->hasFile('image1')) {
                $this->uploadFile($request, $product,'image1');
            }
            if ($request->hasFile('image2')) {
                $this->uploadFile($request, $product, 'image2');
            }

        return redirect()->route('product.index')->withSuccess(trans('New Subcategory has been created'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //dd('here');
        $product = $this->product->find($id);
        $product->delete();
        return redirect()->route('product.index')->withSuccess(trans('product has been deleted'));
    }

    function uploadFile(Request $request, $page, $type = null)
    {
        if ($type == 'image') {
            $file = $request->file('image');
            $path = 'uploads/product';
            //dd($page);
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($page->image))
                $this->__deleteImages($page);

            $data['image'] = $fileName;
        }

        if ($type == 'image1') {
            $file = $request->file('image1');
            $path = 'uploads/product';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($page->image))
                $this->__deleteImages($page);

            $data['image1'] = $fileName;
        }

        if ($type == 'image2') {
            $file = $request->file('image2');
            $path = 'uploads/product';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($page->image))
                $this->__deleteImages($page);

            $data['image2'] = $fileName;
        }

        if ($type == 'banner_image') {
            $file = $request->file('banner_image');
            $path = 'uploads/product';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($page->banner_image))
                $this->__deleteImages($page);

            $data['banner_image'] = $fileName;
        }

        $this->updateImage($page->id, $data);

    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path1))
                unlink($subCat->image_path1);

            if (is_file($subCat->image_path2))
                unlink($subCat->image_path2);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);

        } catch (\Exception $e) {

        }
    }

    public function updateImage($productId, array $data)
    {
        try {
            $product = $this->product->find($productId);
            $product = $product->update($data);
            return $product;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function productCategoryAjax(Request $request)
    {
        $product = $this->subcategory->where('category_id',$request->category_id)->get();
        return response()->json([
            'data' => $product,
            'status' => true,
            'message' => "product Fetched Successfully."
        ]);
    }
}
