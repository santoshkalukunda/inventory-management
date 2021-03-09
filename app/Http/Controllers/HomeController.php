<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Purchase;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalIncome = 0;
        $dueBill = 0;
        $totalPurchase = 0;
        $duePurchase = 0;

        $customers = Customer::get();
        $dealers = Dealer::get();
        $bills = Bill::get();
        foreach ($bills as $bill){
            $totalIncome = $totalIncome + $bill->net_total;
            $dueBill = $dueBill + $bill->due;
        }
        $purchases = Purchase::get();
        foreach ($purchases as $purchase){
            $totalPurchase = $totalPurchase + $purchase->total;
            $duePurchase = $duePurchase + $purchase->due;
        }
        return view('home', compact('customers','dealers','totalIncome','dueBill','totalPurchase','duePurchase'));
    }
}
