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
            $addresses = json_decode($customer->addresses);
            $addresses->addresses[$request->address['index']] = [
                "name" => $request->address['name'],
                "address" => $request->address['address'],
                "suburb" => $request->address['suburb'],
                "zip" => $request->address['zip'],
                "state" => $request->address['state'],
                "country" => "Australia"
            ];

            $customer->update([
                'addresses' =>  json_encode($addresses),
            ]);
            return $addresses;
        }
    }

    public function changeDefaultAddress(Request $request){
        $request->validate([
            'default' => 'required|integer',
            'companyId' => 'required|integer',
        ]);

        $customer = $request->user();
        if($customer->company->id == $request->companyId){
            $addresses = json_decode($customer->addresses);
            $addresses->default = $request->default;

            $customer->update([
                'addresses' =>  json_encode($addresses),
            ]);

            return $addresses;
        }
    }

    public function addAddress(Request $request){
        $request->validate([
            'companyId' => 'required|integer',
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
            $addresses = json_decode($customer->addresses);
            $addresses->addresses[] = [
                "name" => $request->address['name'],
                "address" => $request->address['address'],
                "suburb" => $request->address['suburb'],
                "zip" => $request->address['zip'],
                "state" => $request->address['state'],
                "country" => "Australia"
            ];

            $customer->update([
                'addresses' =>  json_encode($addresses),
            ]);

            return $addresses;
        }
    }

    public function deleteAddress(Request $request){
        $request->validate([
            'companyId' => 'required|integer',
            'address.index' => 'required|integer',
        ]);

        $customer = $request->user();
        if($customer->company->id == $request->companyId){
            $addresses = json_decode($customer->addresses);

            if(count($addresses->addresses) > 1){
                unset($addresses->addresses[$request->address['index']]); //delete address
                $addresses->addresses = array_values($addresses->addresses); // reset index
    
                if($addresses->default == $request->address['index']){ // check if delete default address
                    $addresses->default = 0; // reset default to fisrt address
                }
    
                $customer->update([
                    'addresses' =>  json_encode($addresses),
                ]);
    
                return $addresses;
            }else{
                return response(['message' => 'You cannot delete all addresses!']);
            }
        }
    }
}
