<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider\Slider;
use Illuminate\Http\Request;
use App\Http\Requests\Slider\SliderRequest;

class SliderController extends Controller
{
    protected $slider;

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }
    public function index()
    {


        $slides = Slider::orderBy('created_at', 'asc')->get();
        return view('backend.slider.index', compact('slides'));
    }

    public function create()
    {
        return view('backend.slider.create');
    }

    public function store(SliderRequest $request)
    {
        //
        if($slider = $this->slider->create($request->all())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $slider);
            }
            return redirect()->route('slider.index');

        }
    }

    public function edit(Slider $slider)
    {
        return view('backend.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'max:18072',
        ]);
        if ($slider->update($request->all())) {
            $slider->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $slider);
            }
        }

        return redirect()->route('slider.index')->withSuccess(trans('Slider has been updated'));
    }

    public function destroy($id)
    {

       $slider = Slider::find($id);
       $slider->delete();
       return redirect()->route('slider.index')->withSuccess(trans('Slider has been deleted'));


    }

    function uploadFile(Request $request, $slider)
    {
        $file = $request->file('image');
        $path = 'uploads/slider';
        $fileName = $this->uploadFromAjax($file, $path);
        if (!empty($slider->image))
            $this->__deleteImages($slider);

        $data['image'] = $fileName;
        $this->updateImage($slider->id, $data);

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

    public function updateImage($sliderId, array $data)
    {
        try {
            $slider = Slider::find($sliderId);
            $slider = $slider->update($data);
            return $slider;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
