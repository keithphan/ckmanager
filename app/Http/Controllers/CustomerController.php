<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\DeliverAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        dd($request);
        $request->validate(
            [
                'customerName' => 'required',
                'customerPhoneNumber' => 'required|numeric',
                'customerEmailAddress' => 'required',
                'customerDeliverAddresses' => 'required|array',
                'customerDeliverAddresses.*' => 'required',
            ],
            [
                
            ],
            [
                'customerDeliverAddresses.*' => 'deliver address',
            ],
        );

        $customer = Customer::create([
            'name' => $request->customerName,
            'phone_number' => $request->customerPhoneNumber,
            'email' => $request->customerEmailAddress,
            'company_id' => $request->company_id,
            'user_id' => Auth::user()->id,
        ]);

        $addresses = $request->customerDeliverAddresses;
        for ($x = 0; $x < sizeof($addresses); $x++) {
            DeliverAddress::create([
                'customer_id' => $customer->id,
                'address' => $addresses[$x],
                'is_default' => $x == 0 ? 1 : 0
            ]);
        }

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
        // // $request->validate(
        // //     [
        // //         'customerName' => 'required',
        // //         'customerPhoneNumber' => 'required',
        // //         'customerEmailAddress' => 'required',
        // //         'customerDeliverAddresses' => 'required',
        // //     ],
        // // );

        // $customer = Customer::where('user_id', Auth::user()->id)->find($id);

        // // $customer->update([
        // //     'name' => $request->customerName,
        // //     'phone_number' => $request->customerPhoneNumber,
        // //     'email' => $request->customerEmailAddress,
        // //     'company_id' => $request->company_id,
        // //     'user_id' => Auth::user()->id,
        // // ]);

        // // $addresses = $request->customerDeliverAddresses;
        // // for ($x = 0; $x < sizeof($addresses); $x++) {
        // //     DeliverAddress::create([
        // //         'customer_id' => $customer->id,
        // //         'address' => $addresses[$x],
        // //         'is_default' => $x == 0 ? 1 : 0
        // //     ]);
        // // }

        // dd(DeliverAddress::where('customer_id', $customer->id)->get());

        // Session::flash('message', 'Create customer successfully.');
        // Session::flash('class', 'bg-success');
        // return redirect()->back();
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

        $customer = Customer::select('id', 'name', 'phone_number', 'email')->where('company_id', $company_id)->find($customer_id)->get();
        $deliverAddress = DeliverAddress::select('address')->where([
            ['customer_id', $customer_id],
            ['is_default', 1],
        ])->get()->first();

        return json_encode(['customer' => $customer, 'deliverAddress' => $deliverAddress]);
    }
}
