<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\ZipCode;


class GasStationController extends Controller
{
    /*
        Service for get and filter Api Gas
    */
    public function index(Request $request)
    {
        $zipCodes = ZipCode::all();
        dd($zipCodes);
        $response = Http::get('https://api.datos.gob.mx/v1/precio.gasolina.publico')['results'];
        dd($response);

        // $products = Product::paginate();
        // return view('products.index',compact('products'));
    }

    public function saveZipCodes() {

    }
}
