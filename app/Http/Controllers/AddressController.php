<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function apiIndex()
    {
        $addresses = auth()->user()->addresses()->all();
        return response()->json($addresses);   
    }
}
