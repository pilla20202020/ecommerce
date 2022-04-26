<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Brand\BrandRequest;
use App\Models\Brand\Brand;

class BrandController extends Controller
{
    function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }
    public function index()
    {


        $brand = $this->brand->orderBy('created_at', 'desc')->get();

        return view('backend.brand.index', compact('brand'));
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(BrandRequest $request)
    {
        //dd($request->all());
        if($brand = $this->brand->create($request->data())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $brand);
            }
            return redirect()->route('brand.index');

        }
    }

    public function edit(Brand $brand)
    {
       
        return view('backend.brand.edit', compact('brand'));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
    
        if ($brand->update($request->data())) {
            //dd($request->all());
            $brand->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $brand);
            }
        }

        return redirect()->route('brand.index')->withSuccess(trans('Brand has been updated'));
    }

    public function destroy($id)
    {

       $brand = Brand::find($id);
       $brand->delete();
       return redirect()->route('brand.index')->withSuccess(trans('Brand has been deleted'));


    }

    function uploadFile(Request $request, $brand)
    {
        $file = $request->file('image');
        $path = 'uploads/brand';
        $fileName = $this->uploadFromAjax($file, $path);
        if (!empty($brand->image))
            $this->__deleteImages($brand);

        $data['image'] = $fileName;
        $this->updateImage($brand->id, $data);

    }
    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);
        } catch (\Exception $e) {

        }
    }

    public function updateImage($brandId, array $data)
    {
        try {
            $brand = Brand::find($brandId);
            $brand = $brand->update($data);
            return $brand;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
