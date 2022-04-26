<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\DealRequest;
use App\Models\Deal\Deal;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $deal, $product;

    function __construct(Deal $deal,Product $product)
    {
        $this->deal = $deal;
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
        $deals = $this->deal->orderBy('created_at', 'asc')->get();

        return view('backend.deal.index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = $this->product->get();
        return view('backend.deal.create',compact('products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealRequest $request)
    {
        //
        $deal = $this->deal->create($request->data());

        return redirect()->route('deal.index')->withSuccess(trans('New Deal has been created'));
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
    public function edit(Deal $deal)
    {
        //
        $products = $this->product->get();
        $product_search = $this->product->find($deal->product_id);
        return view('backend.deal.edit', compact('deal','products','product_search'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealRequest $request, Deal $deal)
    {
        //
        if($deal->update($request->data())) {
            return redirect()->route('deal.index')->withSuccess(trans('Deal has been updated'));

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
        $deal = $this->deal->find($id);
        $deal->delete();
        return redirect()->route('deal.index')->withSuccess(trans('deal has been deleted'));
    }
}
