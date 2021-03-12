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
        $purchase_obj = new Purchase;
        for ($i = 0; $i < 30; $i++) {
            $billNetTotals = $bill_obj->where('status', 'complete')->whereDate('date', today()->subDays($i))->get();
            $billTotal[$i] = 0;
            $billPayment[$i] = 0;
            $billDue[$i] = 0;
            $date[$i] = today()->subDays($i);
            $date[$i] = date("Y-m-d", strtotime($date[$i]));
            foreach ($billNetTotals as $netTotal) {
                $billTotal[$i] = $billTotal[$i] + $netTotal->net_total;
                $billPayment[$i] = $billPayment[$i] + $netTotal->payment;
                $billDue[$i] = $billDue[$i] + $netTotal->due;
            }
        }
        $chartjs = app()->chartjs
            ->name('saleLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(array_reverse($date))
            ->datasets([
                [
                    "label" => "Total Sale",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($billTotal),
                ],
                [
                    "label" => "Payment",
                    'backgroundColor' => "rgba(149, 159, 196, 0.31)",
                    'borderColor' => "rgba(149, 159, 196, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($billPayment),
                ],
                [
                    "label" => "Due",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($billDue),
                ],
            ])
            ->options([]);


        $j = 1;
        for ($i = 0; $i < 12; $i++) {
            $purchaseNetTotals = $purchase_obj->whereBetween('order_date', [Carbon::now()->subMonths($j), Carbon::now()->subMonths($i)])->get();
            $j++;
            $months[$i] = today()->subMonths($i);
            $months[$i] = date("Y-m", strtotime($months[$i]));
            $purchaseTotal[$i] = 0;
            $purchaseDue[$i] = 0;
            $purchasePayment[$i] = 0;
            foreach ($purchaseNetTotals as $netTotal) {
                $purchaseTotal[$i] = $purchaseTotal[$i] + $netTotal->total;
                $purchaseDue[$i] = $purchaseDue[$i] + $netTotal->due;
                $purchasePayment[$i] = $purchasePayment[$i] + $netTotal->payment;
            }
        }
        $purchaseChart = app()->chartjs
            ->name('purchaseLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(array_reverse($months))
            ->datasets([
                [
                    "label" => "Total Purchase",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($purchaseTotal),
                ],
                [
                    "label" => "Payment",
                    'backgroundColor' => "rgba(149, 159, 196, 0.31)",
                    'borderColor' => "rgba(149, 159, 196, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($purchasePayment),
                ],
                [
                    "label" => "Due",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($purchaseDue),
                ],

            ])
            ->options([]);

        $j = 1;
        for ($i = 0; $i < 5; $i++) {
            $purchaseNetTotals = $purchase_obj->whereBetween('order_date', [Carbon::now()->subYears($j), Carbon::now()->subYears($i)])->get();
            $billNetTotals = $bill_obj->where('status', 'complete')->whereBetween('date', [Carbon::now()->subYears($j), Carbon::now()->subYears($i)])->get();

            $j++;
            $years[$i] = today()->subYears($i);
            $years[$i] = date("Y", strtotime($years[$i]));
            $billTotalYear[$i] = 0;
            
            foreach ($billNetTotals as $netTotal) {
                $billTotalYear[$i] = $billTotalYear[$i] + $netTotal->net_total;
            }
            $purchaseTotalYear[$i] = 0;
            foreach ($purchaseNetTotals as $netTotal) {
                $purchaseTotalYear[$i] = $purchaseTotalYear[$i] + $netTotal->total;
            }
        }

        $barChart = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 150])
            ->labels(array_reverse($years))
            ->datasets([
                [
                    "label" => "Purchase",
                    'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    'data' => array_reverse($purchaseTotalYear)  
                ],
                [
                    "label" => "Sale",
                    'backgroundColor' => ['rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => array_reverse($billTotalYear)
                ]
            ])
            ->options([]);

        return view('home', compact('customers', 'dealers', 'totalIncome', 'dueBill', 'totalPurchase', 'duePurchase', 'chartjs', 'purchaseChart', 'barChart'));
    }
}
