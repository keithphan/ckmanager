<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\Promise\all;

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

    public function revenue($companySlug, Request $request){
        $request->validate(
            [
                'startDate' => 'required|date_format:Y-m-d',
                'endDate' => 'required|date_format:Y-m-d'
            ]
        );

        $company = Company::select('id', 'name', 'slug')->where([
            ['slug', $companySlug],
            ['user_id', Auth::user()->id]
        ])->get()->first();

        if($request->startDate && $request->endDate && $company){
            $startDate = $request->startDate;
            $endDate = $request->endDate;

            $orders = Order::where([
                ['company_id', $company->id],
                ['user_id', Auth::user()->id]
            ])->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
           
            $deletedOrders = Order::where([
                ['company_id', $company->id],
                ['user_id', Auth::user()->id]
            ])->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->onlyTrashed()->get()->count();
        
            return view('pages.revenue.company', compact('company', 'orders', 'deletedOrders'));
        }
        abort(404);
    }

    public function getDateRevenueByDateRange(Request $request){

        $company = Company::select('id', 'name', 'slug')->where([
            ['slug', $request->companySlug],
            ['user_id', Auth::user()->id]
        ])->get()->first();

        if($request->startDate && $request->endDate && $company){

            $startDate = $request->startDate;
            $endDate = $request->endDate;

            $orders = Order::where([
                ['company_id', $company->id],
                ['user_id', Auth::user()->id],
                ['status', 'successful'],
            ])->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get()->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });

            $result = [];

            foreach($orders as $date => $order){
                $result[$date] = $order->sum('total') / 100;
            }


            return $result;
        }

        

        
    }
}
