<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
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
        foreach ($bills as $bill) {
            $totalIncome = $totalIncome + $bill->net_total;
            $dueBill = $dueBill + $bill->due;
        }
        $purchases = Purchase::get();
        foreach ($purchases as $purchase) {
            $totalPurchase = $totalPurchase + $purchase->total;
            $duePurchase = $duePurchase + $purchase->due;
        }
        $bill_obj = new Bill;
        $purchase_total = new Purchase;
        for ($i = 0; $i < 30; $i++) {
            $billNetTotals = $bill_obj->where('status', 'complete')->whereDate('date', today()->subDays($i))->get();
            $day[$i] = 0;
            foreach ($billNetTotals as $netTotal) {
                $day[$i] = $day[$i] + $netTotal->net_total;
            }
        }
        $j=1;
        for ($i = 0; $i < 12; $i++) {
            $purchaseNetTotals = $purchase_total->whereBetween('order_date', [Carbon::now()->subMonths($j), Carbon::now()->subMonths($i)])->get();
            $j++;
            $months[$i] = 0;
            foreach ($purchaseNetTotals as $netTotal) {
                $months[$i] = $months[$i] + $netTotal->total;
            }
        }
        
        $chartjs = app()->chartjs
            ->name('saleLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(['29 day ago', '28 day ago', '27 day ago', '26 day ago', '25 day ago', '24 day ago', '23 day ago', '22 day ago', '21 day ago', '20 day ago', '19 day ago', '18 day ago', '17 day ago', '16 day ago', '15 day ago', '14 day ago', '13 day ago', '12 day ago', '11 day ago', '10 day ago', '9 day ago', '8 day ago', '7 day ago', '6 day ago', '5 day ago', '4 day ago', '3 day ago', '2 day ago', 'Yesterday', 'Today'])
            ->datasets([
                [
                    "label" => "Sale",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$day[29], $day[28], $day[27], $day[26], $day[25], $day[24], $day[23], $day[22], $day[21], $day[20], $day[19], $day[18], $day[17], $day[16], $day[15], $day[14], $day[13], $day[12], $day[11], $day[10], $day[9], $day[8], $day[7], $day[6], $day[5], $day[4], $day[3], $day[2], $day[1], $day[0]],
                ],
            ])
            ->options([]);

        $purchaseChart = app()->chartjs
            ->name('purchaseLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(['11 months ago', '10 months ago', '9 months ago', '8 months ago', '7 months ago', '6 months ago', '5 months ago', '4 months ago', '3 months ago', '2 months ago', 'Last Monts', 'This month'])
            ->datasets([
                [
                    "label" => "Purchase",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$months[11], $months[10], $months[9], $months[8], $months[7], $months[6], $months[5], $months[4], $months[3], $months[2], $months[1], $months[0]],
                ],

            ])
            ->options([]);

        return view('home', compact('customers', 'dealers', 'totalIncome', 'dueBill', 'totalPurchase', 'duePurchase', 'chartjs', 'purchaseChart'));
    }
}
