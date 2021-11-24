<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::where('user_id', Auth::user()->id)->get();
        return view('pages.customers.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::where('user_id', Auth::user()->id)->get();
        if(!$companies->first()){
            Session::flash('message', "You do not have any companies! <a href='" . route('companies.create') . "'>Create one</a>");
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }
        return view("pages.customers.create", compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'customerName' => 'required',
                'customerPhoneNumber' => 'required|numeric',
                'customerEmailAddress' => 'required',
                'deliverAddresses' => 'required|array',
                'deliverAddresses.*' => 'required',
                'suburbs' => 'required|array',
                'suburbs.*' => 'required',
                'zipCodes' => 'required|array',
                'zipCodes.*' => 'required',
                'states' => 'required|array',
                'states.*' => 'required',
            ],
            [
                
            ],
            [
                'deliverAddresses.*' => 'deliver address',
            ],
        );

        if(count($request->deliverAddresses) > 5){
            Session::flash('message', 'Only 5 addresses allowed!.');
            Session::flash('class', 'bg-danger');
            return redirect()->back();
        }

        $addresses = $request->deliverAddresses;
        
        $addressJson = [];
        
        for($i = 0; $i < count($addresses); $i++){
            $addressJson['addresses'][$i] = [
                'name' => 'Address ' . $i + 1,
                'address' => $request->deliverAddresses[$i],
                'suburb' => $request->suburbs[$i],
                'zip' => (int)$request->zipCodes[$i],
                'state' => $request->states[$i],
                'country' => "Australia"
            ];
        }

        $addressJson['default'] = (int)$request->default;

        $customer = Customer::create([
            'name' => $request->customerName,
            'phone_number' => $request->customerPhoneNumber,
            'email' => $request->customerEmailAddress,
            'addresses' => json_encode($addressJson),
            'password' => Hash::make('123456789'),
            'company_id' => $request->company_id,
            'user_id' => Auth::user()->id,
        ]);
        
        Session::flash('message', 'Create customer successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
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
        $customer = Customer::where('user_id', Auth::user()->id)->find($id);
        $companies = Company::where('user_id', Auth::user()->id)->get();
        return view('pages.customers.edit', compact('customer', 'companies'));
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
        $request->validate(
            [
                'customerName' => 'required',
                'customerPhoneNumber' => 'required|numeric',
                'customerEmailAddress' => 'required',
                'deliverAddresses' => 'required|array',
                'deliverAddresses.*' => 'required',
                'suburbs' => 'required|array',
                'suburbs.*' => 'required',
                'zipCodes' => 'required|array',
                'zipCodes.*' => 'required',
                'states' => 'required|array',
                'states.*' => 'required',
            ],
            [
                
            ],
            [
                'deliverAddresses.*' => 'deliver address',
            ],
        );

        // Return if there are more than 5 addresses
        if(count($request->deliverAddresses) > 5){
            Session::flash('message', 'Only 5 addresses allowed!.');
            Session::flash('class', 'bg-danger');
            return redirect()->back();
        }
        // Update addresses        
        $addresses = $request->deliverAddresses;
        
        $addressJson = [];
        
        for($i = 0; $i < count($addresses); $i++){
            $addressJson['addresses'][$i] = [
                'name' => 'Address ' . $i + 1,
                'address' => $request->deliverAddresses[$i],
                'suburb' => $request->suburbs[$i],
                'zip' => (int)$request->zipCodes[$i],
                'state' => $request->states[$i],
                'country' => "Australia"
            ];
        }

        $addressJson['default'] = (int)$request->default;
        
        $customer = Customer::where('user_id', Auth::user()->id)->find($id);

        $customer->update([
            'name' => $request->customerName,
            'phone_number' => $request->customerPhoneNumber,
            'email' => $request->customerEmailAddress,
            'addresses' => json_encode($addressJson),
            'company_id' => $request->company_id,
        ]);

        Session::flash('message', 'Update customer successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = Customer::find($request->id);

        if($customer){
            $customer->delete();
            Session::flash('message', 'Deleted customer successfully.');
            Session::flash('class', 'bg-success');
        }else{
            $this->isNotExisted();
        }

        return redirect()->back();
    }

    public function destroySelected(Request $request){
        if(!isset($request->itemIds)){
            Session::flash('message', 'No categories selected. Please select!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }

        $customerIds = explode(',', $request->itemIds);

        foreach($customerIds as $id){
            $customer = Customer::find($id);
            if($customer){
                $customer->delete();
            }
        }

        Session::flash('message', 'Deleted customers successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function isNotExisted(){
        Session::flash('message', 'Customer does not exist!');
        Session::flash('class', 'bg-warning');
    }

    public function getCustomerInfoByIdAndCompanyId(Request $request){
        $customer_id = $request->data[0];
        $company_id = $request->data[1];

        $customer = Customer::select('id', 'name', 'phone_number', 'email', 'addresses')->where('company_id', $company_id)->find($customer_id);

        $deliverAddress = "";
        $addressJson = json_decode($customer->addresses);
        foreach($addressJson->addresses as $index => $address){
            if($index == $addressJson->default){
                $deliverAddress = $address;
            }
        }
        
        return json_encode(['customer' => $customer, 'deliverAddress' => $deliverAddress]);
    }
}
