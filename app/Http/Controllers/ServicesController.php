<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Shop;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $services = Service::with(['shop', 'shop.user'])
        //     ->select('shop_id', 'service_name', 'service_price', 'service_duration')
        //     ->get()
        //     ->groupBy('shop.shop_name');
        $shops = Shop::latest()->get();

        return view('services.index', compact('shops'));
    }
}
