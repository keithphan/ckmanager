<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function profile(Request $request){
        $request->validate([
            'companyId' => 'required|integer'
        ]);

        $customer = $request->user();

        if($customer->company->id == $request->companyId){
            return new CustomerResource($customer);
        }
    }

    public function updateCustomerInfo(Request $request){
        $request->validate([
            'customer.name' => 'required',
            'customer.phone_number' => 'required|numeric'
        ],[
            'required' => '* :attribute is required!',
            'numeric' => '* :attribute should be number!',
        ],[
            'customer.name' => 'Name',
            'customer.phone_number' => 'Phone number'
        ]);

        $customer = $request->user();

        $customer->update([
            'name' => $request->customer['name'],
            'phone_number' => $request->customer['phone_number'],
        ]);


    }
}
