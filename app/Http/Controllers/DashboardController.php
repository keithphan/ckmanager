<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $orders = Order::where([
            ['status', 'waitting'],
            ['user_id', Auth::user()->id]
        ])->take(7)->orderBy('created_at', 'DESC')->get();

        $currentYear = Carbon::now()->year;
        $earnings = Order::where([
            ['status', 'successful'],
            ['user_id', Auth::user()->id]
        ])->get()->sum('total');
        $wattingOrders = Order::where([
            ['status', 'waitting'],
            ['user_id', Auth::user()->id]
        ])->get()->count();
        $deletedOrders = Order::where('user_id', Auth::user()->id)->onlyTrashed()->get()->count();
        $currentMonthEarnings = Order::where([
            ['status', 'successful'],
            ['user_id', Auth::user()->id]
        ])->whereMonth('created_at', Carbon::now()->month)->get()->sum('total');
        return view('pages.dashboard', compact('orders' ,'earnings', 'wattingOrders' , 'deletedOrders', 'currentMonthEarnings', 'currentYear'));
    }

    public function getMonthlyRevenue(){
        $monthlyRevenue = [];
        for($i=1; $i <= 12; $i++){
            $monthlyRevenue[] = Order::where([
                ['status', 'successful'],
                ['user_id', Auth::user()->id]
            ])->whereMonth('created_at', $i)->get()->sum('total') / 100;
        }
        return $monthlyRevenue;
    }

    public function getAnnuallyRevenue(){
        $annuallyRevenue = [];
        $pastTwoYear = Carbon::now()->year - 2;
        for($i = $pastTwoYear; $i <= $pastTwoYear + 4; $i++){
            $annuallyRevenue[] = Order::where([
                ['status', 'successful'],
                ['user_id', Auth::user()->id]
            ])->whereYear('created_at', $i)->get()->sum('total') / 100;
        }
        return $annuallyRevenue;
    }
}
