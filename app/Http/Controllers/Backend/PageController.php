<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Page\StorePage;
use App\Models\Page\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */

    protected $page;

    function __construct(Page $page)
    {
        $this->page = $page;

    }
    public function index()
    {
        $pages = $this->page->orderBy('created_at', 'desc')->get();

        return view('backend.page.index', compact('pages'));
    }

    /**
     * @return \Illuminate\View\View
     */
    // public function resourceIndex()
    // {
    //     $pages = Page::where('view', 'Resource')->get();

    //     return view('backend.resources.index', compact('pages'));
    // }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        //$pages = $this->page->get();
        return view('backend.page.create');
    }

    /**
     * @param StorePage $request
     * @return mixed
     */
    public function store(StorePage $request)
    {

//        DB::transaction(function () use ($request)
//        {
//            $page = Page::create($request->pageFillData());
//
//            $this->uploadRequestImage($request, $page);
//        });

        if ($page = $this->page->create($request->pageFillData())) {
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $page, 'image');
            }
            if ($request->hasFile('banner_image')) {
                $this->uploadFile($request, $page, 'banner_image');
            }
            return redirect()->route('page.index');


        }


    }

    /**
     * @param Page $page
     * @return \Illuminate\View\View
     */
    public function edit(Page $page)
    {
       // $pages = $this->page->get();
        return view('backend.page.edit', compact('page'));
    }

    public function update(StorePage $request, Page $page)
    {

        if ($page->update($request->pageFillData())) {
            $page->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $page, 'image');
            }
            if ($request->hasFile('banner_image')) {
                $this->uploadFile($request, $page, 'banner_image');
            }
        }
//        DB::transaction(function () use ($request, $page)
//        {
//            $page->update($request->pageFillData());
//
//            $this->uploadRequestImage($request, $page);
//        });

        return redirect()->route('page.index')->withSuccess(trans('Page has been updated'));
    }

    public function destroy($id)
    {
        $page = $this->page->find($id);
        $page->delete();
        return redirect()->route('page.index')->withSuccess(trans('page has been deleted'));
    }

    function uploadFile(Request $request, $page, $type = null)
    {
        if ($type == 'image') {
            $file = $request->file('image');
            $path = 'uploads/page';
            $fileName = $this->uploadFromAjax($file, $path);
            if (!empty($page->image))
                $this->__deleteImages($page);

            $data['image'] = $fileName;
        }
        if ($type == 'banner_image') {
            $file = $request->file('banner_image');
            $path = 'uploads/banner_image';
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
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);

            if (is_file($subCat->banner_path))
                unlink($subCat->banner_path);

        } catch (\Exception $e) {

        }
    }

    public function updateImage($pageId, array $data)
    {
        try {
            $page = Page::find($pageId);
            $page = $page->update($data);
            return $page;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
