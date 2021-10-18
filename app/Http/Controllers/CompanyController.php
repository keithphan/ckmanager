<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get every companies of logged in user.
        $companies = Company::select('id', 'name')->where('user_id', Auth::user()->id)->get();
        return view("pages.companies.index", compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pages.companies.create");
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
                'name' => 'required'
            ],
        );

        Company::create([
            'name' => $request->name,
            'logo' => $request->logo,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ]);

        Session::flash('message', 'Create company successfully.');
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
        // Get a company by id of logged user.
        $company = Company::select('id', 'name', 'logo', 'description')->where('user_id', Auth::user()->id)->find($id);

        if(!$company){
            $this->isNotExisted();
            return redirect()->back();
        }

        return view('pages.companies.edit', compact('company'));
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
                'name' => 'required'
            ],
        );

        $company = Company::where('user_id', Auth::user()->id)->find($id);

        if(!$company){
            $this->isNotExisted();
            return redirect()->back();
        }

        $company->update([
            'name' => $request->name,
            'logo' => $request->logo,
            'description' => $request->description,
        ]);

        Session::flash('message', 'Update company successfully.');
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
        $company = Company::where('user_id', Auth::user()->id)->find($request->id);

        if(!$company){
            $this->isNotExisted();
            return redirect()->back();
        }

        $company->delete();

        Session::flash('message', 'Deleted company successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function destroySelected(Request $request){
        // Check if user choose items or not.
        if(!isset($request->itemIds)){
            Session::flash('message', 'No companies selected. Please select!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }
        
        $companyIds = explode(',', $request->itemIds);

        foreach($companyIds as $id){
            $company = Company::where('user_id', Auth::user()->id)->find($id);
            // Return back with error if company does not exist.
            if(!$company){
                $this->isNotExisted();
                return redirect()->back();
            }else{
                $company->delete();
            }
        }

        Session::flash('message', 'Deleted companies successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function isNotExisted(){
        Session::flash('message', 'Company does not exist!');
        Session::flash('class', 'bg-warning');
    }
}
