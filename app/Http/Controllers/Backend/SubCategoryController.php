<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategory\SubCategoryRequest;
use App\Models\Category\Category;
use App\Models\SubCategory\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class SubCategoryController extends Controller
{
    function __construct(SubCategory $subcategory, Category $category)
    {
        $this->subcategory = $subcategory;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $subcategories = $this->subcategory->orderBy('created_at', 'desc')->get();

        return view('backend.subcategory.index', compact('subcategories'));
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
        return view('backend.subcategory.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        //
        $request->validate([
            'category_id' => 'required'
        ]);
        if ($subcategory = $this->subcategory->create($request->data())) {

            if ($request->hasFile('image')) {
                $this->uploadFile($request, $subcategory);
            }
        }

        return redirect()->route('subcategory.index')->withSuccess(trans('New Subcategory has been created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        //
        $category_search = $this->category->find($subcategory->category_id);
        $categories = $this->category->get();
        return view('backend.subcategory.edit', compact('subcategory','category_search','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required',
            'title'      => 'required|max:255',
        ]);
        if ($subcategory->update($request->data())) {
            $subcategory->fill([
                'slug' => Str::slug($request->title),
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $subcategory);
            }
        }

        return redirect()->route('subcategory.index')->withSuccess(trans('SubCategory has been updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $subcategory = $this->subcategory->find($id);
        $subcategory->delete();
        return redirect()->route('subcategory.index')->withSuccess(trans('subcategory has been deleted'));
    }

    function uploadFile(Request $request, $subcategory)
    {
        $file = $request->file('image');
        $path = 'uploads/subcategory';
        $fileName = $this->uploadFromAjax($file, $path);
        if (!empty($subcategory->image))
            $this->__deleteImages($subcategory);

        $data['image'] = $fileName;
        $this->updateImage($subcategory->id, $data);

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

    public function updateImage($subcategoryId, array $data)
    {
        try {
            $subcategory = $this->subcategory->find($subcategoryId);
            $subcategory = $subcategory->update($data);
            return $subcategory;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
