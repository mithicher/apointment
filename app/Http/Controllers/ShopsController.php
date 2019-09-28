<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;

class ShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = auth()->user()->shops;

        if (request()->expectsJson()) {
            return response(['data' => $shops, 'status' => 'success'], 200);
        }

        return view('shops.index', compact('shops'));
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
        $this->validate($request, [
            'shop_name' => 'required',
            // 'shop_phone' => 'required|digits_between:10,10',
            'shop_phone' => [
                'required',
                'regex:/^[6789]\d{9}$/'
            ],
            'shop_address' => 'required'
        ], [
            'shop_phone.digits_between' => 'Please enter a valid 10 digit phone no.',
            'shop_phone.regex' => 'Please enter a valid 10 digit phone no.'
        ]);

        $shop = auth()->user()->shops()->create([
            'shop_name' => $request->shop_name,
            'shop_phone' => $request->shop_phone,
            'shop_address' => $request->shop_address,
        ]);

        if ($request->expectsJson()) {
            return response(['data' => $shop, 'status' => 'success'], 201);
        }

        session()->flash('success', 'New shop created!');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $shop->load('services');

        return view('shops.show', compact('shop'));
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'shop_name' => 'required',
            'shop_phone' => [
                'required',
                'regex:/^[6789]\d{9}$/'
            ],
            'shop_address' => 'required'
        ], [
            'shop_phone.regex' => 'Please enter a valid 10 digit phone no.'
        ]);

        $shop = Shop::find($id);
        $shop->fill($request->all());
        $shop->save();

        if ($request->expectsJson()) {
            return response(['data' => $shop, 'status' => 'success'], 201);
        }

        session()->flash('success', 'New shop created!');

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

    public function updateShopStatus(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->shop_isactive = $request->shop_status;
        $shop->save();

        if ($request->expectsJson()) {
            return response(['data' => $shop, 'status' => 'success'], 201);
        }

        return back();
    }
}
