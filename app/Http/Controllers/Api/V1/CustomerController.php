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
            'customer.phone_number' => 'required|numeric',
            'companyId' => 'required|integer'
        ],[
            'required' => '* :attribute is required!',
            'numeric' => '* :attribute should be number!',
        ],[
            'customer.name' => 'Name',
            'customer.phone_number' => 'Phone number'
        ]);

        $customer = $request->user();

        if($customer->company->id == $request->companyId){

            $customer->update([
                'name' => $request->customer['name'],
                'phone_number' => $request->customer['phone_number'],
            ]);
    
            return new CustomerResource($customer);
        }
        
    }

    public function updateCustomerAddresses(Request $request){
        $request->validate([
            'companyId' => 'required|integer',
            'address.index' => 'required|integer',
            'address.name' => 'required',
            'address.address' => 'required',
            'address.suburb' => 'required',
            'address.zip' => 'required',
            'address.state' => 'required',
        ],[
            'required' => '* :attribute is required!',
        ],[
            'address.name' => 'Address type',
            'address.address' => 'Address',
            'address.suburb' => 'City / Suburb',
            'address.zip' => 'Zip code',
            'address.state' => 'State',
        ]);

        $customer = $request->user();

        if($customer->company->id == $request->companyId){
            $addreeses = json_decode($customer->addresses);
            $addreeses->addresses[$request->address['index']] = [
                "name" => $request->address['name'],
                "address" => $request->address['address'],
                "suburb" => $request->address['suburb'],
                "zip" => $request->address['zip'],
                "state" => $request->address['state'],
                "country" => "Australia"
            ];

            $customer->update([
                'addresses' =>  json_encode($addreeses),
            ]);
            return $addreeses;
        }

        return $request;
    }
}
