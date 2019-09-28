<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ShopServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = collect(auth()->user()->shops->firstOrFail()->services)->paginate($request->perPage);
        
        if (request()->expectsJson()) {
            return response(['data' => $services, 'status' => 'success'], 201);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $this->validate($request, [
            'service_name' => 'required',
            'service_details' => 'required',
            'service_duration' => 'required',
            'service_price' => 'required|numeric',
            'service_isactive' => 'required'
        ]);

        $service = Service::create([
            'shop_id' => auth()->user()->shops[0]->id,
            'service_name' => $input['service_name'],
            'service_details' => $input['service_details'],
            'service_duration' => $input['service_duration'],
            'service_price' => $input['service_price'],
            'service_isactive' => $input['service_isactive']
        ]);

        if ($request->expectsJson()) {
            return response(['data' => $service, 'status' => 'success'], 201);
        }

        session()->flash('success', 'New service created!');

        return back();
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop, $serviceId)
    {
        $input = $this->validate($request, [
            'service_name' => 'required',
            'service_details' => 'required',
            'service_duration' => 'required',
            'service_price' => 'required|numeric',
            'service_isactive' => 'required'
        ]);

        $service = Service::whereId($serviceId)->update([
            'shop_id' => auth()->user()->shops[0]->id,
            'service_name' => $input['service_name'],
            'service_details' => $input['service_details'],
            'service_duration' => $input['service_duration'],
            'service_price' => $input['service_price'],
            'service_isactive' => $input['service_isactive']
        ]);

        if ($request->expectsJson()) {
            return response(['data' => $service, 'status' => 'success'], 201);
        }

        session()->flash('success', 'Shop Service updated!');

        return back();
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
    }

    public function getShopServices(Request $request, $shopId)
    {
        $services = collect(auth()->user()->shops->firstOrFail()->services)->paginate($request->perPage);

        // $services = Service::select('id', 'shop_id', 'service_name', 'service_price', 'service_duration', 'service_details', 'service_isactive')
        //     ->whereShopId($shopId)
        //     // ->whereUserId(auth()->user()->id)
        //     ->latest()
        //     ->paginate($request->perPage);

        if (request()->expectsJson()) {
            return response(['data' => $services, 'status' => 'success'], 201);
        }
    }
}
