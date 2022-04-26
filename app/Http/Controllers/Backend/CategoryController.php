<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    function __construct(Category $category)
    {
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
        $categories = $this->category->orderBy('created_at', 'desc')->get();

        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('backend.category.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
        if ($category = $this->category->create($request->data())) {
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $category);
            }
        }

        return redirect()->route('category.index')->withSuccess(trans('New Category has been created'));


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
    public function edit(Category $category)
    {
        //

        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //
        if($category->update($request->data())) {
            $category->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $category);
            }
            return redirect()->route('category.index')->withSuccess(trans('Category has been updated'));

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
        //
        $category = $this->category->find($id);
        $category->delete();
        return redirect()->route('category.index')->withSuccess(trans('Category has been deleted'));
    }

    function uploadFile(Request $request, $category)
    {
        $file = $request->file('image');
        $path = 'uploads/category';
        $fileName = $this->uploadFromAjax($file, $path);
        if (!empty($category->image))
            $this->__deleteImages($category);

        $data['image'] = $fileName;
        $this->updateImage($category->id, $data);

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

    public function updateImage($categoryId, array $data)
    {
        try {
            $category = $this->category->find($categoryId);
            $category = $category->update($data);
            return $category;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
