<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\PurchaseBill;
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
        $totalPurchaseBill = 0;
        $duePurchaseBill = 0;

        $customers = Customer::get();
        $dealers = Dealer::get();
        $bills = Bill::where('status', 'complete')->get();
        foreach ($bills as $bill) {
            $totalIncome = $totalIncome + $bill->net_total;
            $dueBill = $dueBill + $bill->due;
        }
        $PurchaseBills = PurchaseBill::where('status', 'complete')->get();
        foreach ($PurchaseBills as $PurchaseBill) {
            $totalPurchaseBill = $totalPurchaseBill + $PurchaseBill->total;
            $duePurchaseBill = $duePurchaseBill + $PurchaseBill->due;
        }
        $bill_obj = new Bill;
        $PurchaseBill_obj = new PurchaseBill;
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
            $PurchaseBillNetTotals = $PurchaseBill_obj->whereBetween('order_date', [Carbon::now()->subMonths($j), Carbon::now()->subMonths($i)])->get();
            $j++;
            $months[$i] = today()->subMonths($i);
            $months[$i] = date("Y-m", strtotime($months[$i]));
            $PurchaseBillTotal[$i] = 0;
            $PurchaseBillDue[$i] = 0;
            $PurchaseBillPayment[$i] = 0;
            foreach ($PurchaseBillNetTotals as $netTotal) {
                $PurchaseBillTotal[$i] = $PurchaseBillTotal[$i] + $netTotal->total;
                $PurchaseBillDue[$i] = $PurchaseBillDue[$i] + $netTotal->due;
                $PurchaseBillPayment[$i] = $PurchaseBillPayment[$i] + $netTotal->payment;
            }
        }
        $PurchaseBillChart = app()->chartjs
            ->name('PurchaseBillLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(array_reverse($months))
            ->datasets([
                [
                    "label" => "Total PurchaseBill",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($PurchaseBillTotal),
                ],
                [
                    "label" => "Payment",
                    'backgroundColor' => "rgba(149, 159, 196, 0.31)",
                    'borderColor' => "rgba(149, 159, 196, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($PurchaseBillPayment),
                ],
                [
                    "label" => "Due",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => array_reverse($PurchaseBillDue),
                ],

            ])
            ->options([]);

        $j = 1;
        for ($i = 0; $i < 5; $i++) {
            $PurchaseBillNetTotals = $PurchaseBill_obj->whereBetween('order_date', [Carbon::now()->subYears($j), Carbon::now()->subYears($i)])->get();
            $billNetTotals = $bill_obj->where('status', 'complete')->whereBetween('date', [Carbon::now()->subYears($j), Carbon::now()->subYears($i)])->get();

            $j++;
            $years[$i] = today()->subYears($i);
            $years[$i] = date("Y", strtotime($years[$i]));
            $billTotalYear[$i] = 0;
            
            foreach ($billNetTotals as $netTotal) {
                $billTotalYear[$i] = $billTotalYear[$i] + $netTotal->net_total;
            }
            $PurchaseBillTotalYear[$i] = 0;
            foreach ($PurchaseBillNetTotals as $netTotal) {
                $PurchaseBillTotalYear[$i] = $PurchaseBillTotalYear[$i] + $netTotal->total;
            }
        }

        $barChart = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 150])
            ->labels(array_reverse($years))
            ->datasets([
                [
                    "label" => "PurchaseBill",
                    'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    'data' => array_reverse($PurchaseBillTotalYear)  
                ],
                [
                    "label" => "Sale",
                    'backgroundColor' => ['rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => array_reverse($billTotalYear)
                ]
            ])
            ->options([]);

        return view('home', compact('customers', 'dealers', 'totalIncome', 'dueBill', 'totalPurchaseBill', 'duePurchaseBill', 'chartjs', 'PurchaseBillChart', 'barChart'));
    }
}
