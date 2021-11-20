<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'companyId' => 'required',
            'customer.email' => 'required|email',
            'customer.password' => 'required|min:6',
        ]);

        if(Auth::guard('customer')->attempt([
            'email' => $request->customer['email'],
            'password' => $request->customer['password'],
            'company_id' => $request->companyId,
        ])){

            $token = Auth::guard('customer')->user()->createToken('authToken')->accessToken;
            return response(['customer' => Auth::guard('customer')->user(), 'access_token' => $token]);
        }

        return response([ 'message' => '* Email or password is not correct!' ]);
    }

    public function register(Request $request){
        
        $request->validate([
            'companyId' => 'required|integer',
            'customer.firstname' => 'required|string',
            'customer.lastname' => 'required|string',
            'customer.email' => 'required|email',
            'customer.password' => 'required|min:6',
        ]);

        $customer = Customer::where([
            ['email', $request->customer['email']],
            ['company_id', $request->companyId]
        ])->get()->first();

        if($customer){
            return response([ 'message' => '* Your email is taken!' ]);
        }
        
        $company = Company::find($request->companyId);

        if(!$company){
            return response([ 'message' => '* Invalid request!' ]);
        }

        $newCus = Customer::create([
            'name' => $request->customer['firstname'] . " " . $request->customer['lastname'],
            'email' => $request->customer['email'],
            'password' => Hash::make($request->customer['password']),
            'company_id' => $company->id,
            'user_id' => $company->user->id,
        ]);
        
        if(Auth::guard('customer')->attempt([
            'email' => $request->customer['email'],
            'password' => $request->customer['password'],
            'company_id' => $request->companyId,
        ])){

            $token = Auth::guard('customer')->user()->createToken('authToken')->accessToken;
            return response(['access_token' => $token]);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'status' => 'success',
        ]);
    }
}
