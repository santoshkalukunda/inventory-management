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
            $total[$i] = 0;
            $billPayment[$i] = 0;
            $billDue[$i] = 0;
            foreach ($billNetTotals as $netTotal) {
                $total[$i] = $total[$i] + $netTotal->net_total;
                $billPayment[$i] = $billPayment[$i]+$netTotal->payment;
                $billDue[$i] = $billDue[$i]+$netTotal->due;
            }
        }
        $j=1;
        for ($i = 0; $i < 12; $i++) {
            $purchaseNetTotals = $purchase_total->whereBetween('order_date', [Carbon::now()->subMonths($j), Carbon::now()->subMonths($i)])->get();
            $j++;
            $months[$i] = 0;
            $purchaseDue[$i]=0;
            $purchasePayment[$i]=0;
            foreach ($purchaseNetTotals as $netTotal) {
                $months[$i] = $months[$i] + $netTotal->total;
                $purchaseDue[$i]= $purchaseDue[$i] +$netTotal->due;
                $purchasePayment[$i]= $purchasePayment[$i] +$netTotal->payment;

            }
        }
        
        $chartjs = app()->chartjs
            ->name('saleLineChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 100])
            ->labels(['29 day ago', '28 day ago', '27 day ago', '26 day ago', '25 day ago', '24 day ago', '23 day ago', '22 day ago', '21 day ago', '20 day ago', '19 day ago', '18 day ago', '17 day ago', '16 day ago', '15 day ago', '14 day ago', '13 day ago', '12 day ago', '11 day ago', '10 day ago', '9 day ago', '8 day ago', '7 day ago', '6 day ago', '5 day ago', '4 day ago', '3 day ago', '2 day ago', 'Yesterday', 'Today'])
            ->datasets([
                [
                    "label" => "Total Sale",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$total[29], $total[28], $total[27], $total[26], $total[25], $total[24], $total[23], $total[22], $total[21], $total[20], $total[19], $total[18], $total[17], $total[16], $total[15], $total[14], $total[13], $total[12], $total[11], $total[10], $total[9], $total[8], $total[7], $total[6], $total[5], $total[4], $total[3], $total[2], $total[1], $total[0]],
                ],
                [
                    "label" => "Payment",
                    'backgroundColor' => "rgba(149, 159, 196, 0.31)",
                    'borderColor' => "rgba(149, 159, 196, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$billPayment[29], $billPayment[28], $billPayment[27], $billPayment[26], $billPayment[25], $billPayment[24], $billPayment[23], $billPayment[22], $billPayment[21], $billPayment[20], $billPayment[19], $billPayment[18], $billPayment[17], $billPayment[16], $billPayment[15], $billPayment[14], $billPayment[13], $billPayment[12], $billPayment[11], $billPayment[10], $billPayment[9], $billPayment[8], $billPayment[7], $billPayment[6], $billPayment[5], $billPayment[4], $billPayment[3], $billPayment[2], $billPayment[1], $billPayment[0]],
                ],
                [
                    "label" => "Due",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$billDue[29], $billDue[28], $billDue[27], $billDue[26], $billDue[25], $billDue[24], $billDue[23], $billDue[22], $billDue[21], $billDue[20], $billDue[19], $billDue[18], $billDue[17], $billDue[16], $billDue[15], $billDue[14], $billDue[13], $billDue[12], $billDue[11], $billDue[10], $billDue[9], $billDue[8], $billDue[7], $billDue[6], $billDue[5], $billDue[4], $billDue[3], $billDue[2], $billDue[1], $billDue[0]],
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
                    "label" => "Total Purchase",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$months[11], $months[10], $months[9], $months[8], $months[7], $months[6], $months[5], $months[4], $months[3], $months[2], $months[1], $months[0]],
                ],
                [
                    "label" => "Payment",
                    'backgroundColor' => "rgba(149, 159, 196, 0.31)",
                    'borderColor' => "rgba(149, 159, 196, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$purchasePayment[11], $purchasePayment[10], $purchasePayment[9], $purchasePayment[8], $purchasePayment[7], $purchasePayment[6], $purchasePayment[5], $purchasePayment[4], $purchasePayment[3], $purchasePayment[2], $purchasePayment[1], $purchasePayment[0]],
                ],
                [
                    "label" => "Due",
                    'backgroundColor' => "rgba(230, 147, 115, 0.31)",
                    'borderColor' => "rgba(230, 147, 115, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [$purchaseDue[11], $purchaseDue[10], $purchaseDue[9], $purchaseDue[8], $purchaseDue[7], $purchaseDue[6], $purchaseDue[5], $purchaseDue[4], $purchaseDue[3], $purchaseDue[2], $purchaseDue[1], $purchaseDue[0]],
                ],

            ])
            ->options([]);

        return view('home', compact('customers', 'dealers', 'totalIncome', 'dueBill', 'totalPurchase', 'duePurchase', 'chartjs', 'purchaseChart'));
    }
}
