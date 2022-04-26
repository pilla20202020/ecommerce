<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training\Training;
use App\Models\Service\Service;
use App\Http\Requests\Training\TrainingRequest;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $training, $service;

    function __construct(Training $training, Service $service)
    {
        $this->training = $training;
        $this->service = $service;

    }
    public function index()
    {
        $training = $this->training->orderBy('created_at', 'desc')->get();

        return view('backend.training.index', compact('training'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Training $training)
    {
      
        $services = $this->service->get();
       
        return view('backend.training.create',compact('services','training'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingRequest $request)
    {
       // dd($request->all());
        if($training = $this->training->create($request->data())) {
            if($request->hasFile('image')) {
                $this->uploadFile($request, $training);
            }
            return redirect()->route('training.index');

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
    public function edit(Training $training)
    {
      
        $service_search = Service::find($training->service_id);
        $services = $this->service->get();
        // dd($gallery->Service()->get('name'));
        return view('backend.training.edit', compact('training','services','service_search'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingRequest $request, Training $training)
    {
        $request->validate([
            'service_id' => 'required',
            'title'      => 'required|max:255',
        ]);
        if ($training->update($request->data())) {
            $training->fill([
                'slug' => $request->title,
            ])->save();
            if ($request->hasFile('image')) {
                $this->uploadFile($request, $training);
            }
        }
        return redirect()->route('training.index')->withSuccess(trans('Training has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = $this->training->find($id);
        $training->delete();
        return redirect()->route('training.index')->withSuccess(trans('Training has been deleted'));
    }   

    function uploadFile(Request $request, $training)
    {
        $file = $request->file('image');
        $path = 'uploads/training';
        $fileName = $this->uploadFromAjax($file, $path);
        if (!empty($training->image))
            $this->__deleteImages($training);

        $data['image'] = $fileName;
        $this->updateImage($training->id, $data);

    }

    public function updateImage($trainingId, array $data)
    {
        try {
            $training = $this->training->find($trainingId);
            $training = $training->update($data);
            return $training;
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
        } catch (\Exception $e) {

        }
    }
}
