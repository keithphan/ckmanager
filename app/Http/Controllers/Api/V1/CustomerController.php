<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function login(Request $request){
        return $request->customer;
    }

    public function register(Request $request){
        return $request->customer;
    }
}
