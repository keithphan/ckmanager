<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RevenueController extends Controller
{
    public function index(){
        $companies = Company::select('id', 'name', 'slug')->where('user_id', Auth::user()->id)->get();
        if(!$companies->first()){
            Session::flash('message', "You do not have any companies! <a href='" . route('companies.create') . "'>Create one</a>");
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }
        return view('pages.revenue.index' , compact('companies'));
    }

    public function revenue($companySlug){
        $company = Company::select('id', 'name', 'slug')->where([
            ['slug', $companySlug],
            ['user_id', Auth::user()->id]
        ])->get()->first();

        return view('pages.revenue.company', compact('company'));
    }
}
