<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service\Service;
use App\Http\Requests\Service\ServiceRequest;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;

    function __construct(Service $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $service = $this->service->orderBy('created_at', 'desc')->get();

        return view('backend.service.index', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
       // dd($request->all());
        if($service = $this->service->create($request->data())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $service,'image');
            }

            return redirect()->route('service.index');

        }
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
    public function edit(Service $service)
    {
      
        return view('backend.service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
       
        if ($service->update($request->data())) {
            $service->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $service,'image');
            }
            
        }
        return redirect()->route('service.index')->withSuccess(trans('Service has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = $this->service->find($id);
        $service->delete();
        return redirect()->route('service.index')->withSuccess(trans('Service has been deleted'));
    }   

    function uploadFile(Request $request, $service, $type = null)
    {
        if ($type == 'image') {
            $file = $request->file('image');
            $path = 'uploads/service';
            $fileName = $this->uploadFromAjax($file, $path);
           
            $data['image'] = $fileName;
        }
    
        $this->updateImage($service->id, $data);

    }

    public function updateImage($serviceId, array $data)
    {
        try {
            $service = $this->service->find($serviceId);
            $service = $service->update($data);
            return $service;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);

            if (is_file($subCat->icon_path))
            unlink($subCat->icon_path);
        } catch (\Exception $e) {

        }
    }
}
