<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::get();
        $total = 0;
        $due = 0;
        $payment = 0;
        foreach ($bills as $bill) {
            if ($bill->status == "cancel") {
                continue;
            }
            $total = $total + $bill->net_total;
            $payment = $payment + $bill->payment;
            $due = $due + $bill->due;
        }
        $customers = Customer::get();
        $users = User::get();
        $bills = Bill::with('customer', 'user', 'sale')->latest()->paginate(200);
        return view('bill.index', compact('bills', 'customers', 'users', 'total', 'due', 'payment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Sale $sale = null, Bill $bill)
    {

        $stores = Store::with('product', 'category', 'brand', 'unit')->where('quantity', '>', 0)->latest()->get();
        if (!$sale) {
            $sale = new Sale;
        }
        $sales = $bill->sale()->with('store', 'unit', 'product')->get();
        $salestotal = 0;
        foreach ($sales as $total) {
            $salestotal = $salestotal + $total->total;
        }

        return view('bill.create', compact('bill', 'sale', 'stores', 'sales', 'salestotal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer)
    {
        $bill = $customer->bill()->create([
            'user_id' => Auth::user()->id,
            'status' => 'incomplete',
        ]);
        return redirect()->route('bills.create', compact('bill'))->with('success', 'New Bill Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        $saleDues = $bill->saleDue()->latest()->paginate();
        return view('bill.show', compact('bill', 'saleDues'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function edit(Bill $bill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function update(BillRequest $request, Bill $bill)
    {
        $invoice_no = Bill::max('invoice_no');
        $invoice_no = $invoice_no + 1;
        $due = $request->due;
        $bill->update([
            'date' => $request->date,
            'invoice_no' => $invoice_no,
            "total" => $request->total,
            "discount" => $request->discount,
            "discount_in" => $request->discount_in,
            "vat" => $request->vat,
            'net_total' => $request->net_total,
            'payment' => $request->payment,
            'due' => $due,
            'status' => 'complete',
            'user_id' => Auth::user()->id,
            'remarks' => $request->remarks,
        ]);
        $bill->sale()->update([
            'date' => $request->date,
            'invoice_no' => $invoice_no,
        ]);
        return redirect()->back()->with('success', "Pyament Successfull");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $sales = Sale::where('bill_id', $bill->id)->where('customer_id', $bill->customer_id)->get();
        foreach ($sales as $sale) {
            $store = Store::findOrFail($sale->store_id);
            $store->update([
                'quantity' => $store->quantity + $sale->quantity,
            ]);
            $sale->delete();
        }
        $bill->delete();
        return redirect()->back()->with('success', "Bill cancel Successfull");
    }

    public function cancel(Bill $bill)
    {
        $bill->update([
            'status' => 'cancel',
        ]);
        $sales = Sale::where('bill_id', $bill->id)->where('customer_id', $bill->customer_id)->get();
        foreach ($sales as $sale) {
            $store = Store::findOrFail($sale->store_id);
            $store->update([
                'quantity' => $store->quantity + $sale->quantity,
            ]);
        }
        return redirect()->back()->with('success', "Bill cancel Successfull");
    }

    public function search(Request $request)
    {

        $bills = new Bill;
        if ($request->has('customer_id')) {
            if ($request->customer_id != null)
                $bills = $bills->where('customer_id', ["$request->customer_id"]);
        }
        if ($request->has('bill_date_from')) {
            if ($request->bill_date_from != null && $request->bill_date_to != null)
                $bills = $bills->whereBetween('date', [$request->bill_date_from, $request->bill_date_to]);
        }
        if ($request->has('user_id')) {
            if ($request->user_id != null)
                $bills = $bills->where('user_id', ["$request->user_id"]);
        }
        if ($request->has('status')) {
            if ($request->status != null)
                $bills = $bills->where('status', ["$request->status"]);
        }
        if ($request->has('discount_in')) {
            if ($request->discount_in != null)
                $bills = $bills->where('discount_in', ["$request->discount_in"]);
        }
        $bills = $bills->when($request->has('invoice_no_min') && !is_null($request->invoice_no_min), function ($query) use ($request) {
            $query->where('invoice_no', '>=', $request->invoice_no_min);
        })
            ->when($request->has('invoice_no_max') && !is_null($request->invoice_no_max), function ($query) use ($request) {
                $query->where('invoice_no', '<=', (int)$request->invoice_no_max);
            });
        $bills = $bills->when($request->has('discount_min') && !is_null($request->discount_min), function ($query) use ($request) {
            $query->where('discount', '>=', $request->discount_min);
        })
            ->when($request->has('discount_max') && !is_null($request->discount_max), function ($query) use ($request) {
                $query->where('discount', '<=', (int)$request->discount_max);
            });
        $bills = $bills->when($request->has('vat_min') && !is_null($request->vat_min), function ($query) use ($request) {
            $query->where('vat', '>=', $request->vat_min);
        })
            ->when($request->has('vat_max') && !is_null($request->vat_max), function ($query) use ($request) {
                $query->where('vat', '<=', (int)$request->vat_max);
            });

        $bills = $bills->when($request->has('total_min') && !is_null($request->total_min), function ($query) use ($request) {
            $query->where('total', '>=', $request->total_min);
        })
            ->when($request->has('total_max') && !is_null($request->total_max), function ($query) use ($request) {
                $query->where('total', '<=', (int)$request->total_max);
            });
        $bills = $bills->when($request->has('net_total_min') && !is_null($request->net_total_min), function ($query) use ($request) {
            $query->where('net_total', '>=', $request->net_total_min);
        })
            ->when($request->has('net_total_max') && !is_null($request->net_total_max), function ($query) use ($request) {
                $query->where('net_total', '<=', (int)$request->net_total_max);
            });
        $bills = $bills->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });
        $bills = $bills->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });
        $customers = Customer::get();
        $users = User::get();

        $bills = $bills->with('customer', 'user', 'sale')->latest()->paginate(10000);
        $total = 0;
        $due = 0;
        $payment = 0;
        foreach ($bills as $bill) {
            if ($bill->status == "cancel") {
                continue;
            }
            $total = $total + $bill->net_total;
            $payment = $payment + $bill->payment;
            $due = $due + $bill->due;
        }
        return view('bill.index', compact('bills', 'customers', 'users', 'total', 'due', 'payment'));
    }

    public function pdf(Bill $bill)
    {
        $company = Company::findOrFail(1);
        $sales = $bill->sale()->get();
        $pdf = PDF::loadView('pdf.bill-pdf', compact('sales', 'bill', 'company'));
        return $pdf->setPaper('A4')->stream($bill->customer->name . $bill->id . ".pdf");
        //    return view('pdf.bill-pdf',compact('sales','bill'));
    }

    public function report(Request $request)
    {

        $bills = new Bill;
        if ($request->has('customer_id')) {
            if ($request->customer_id != null)
                $bills = $bills->where('customer_id', ["$request->customer_id"]);
        }
        if ($request->has('bill_date_from')) {
            if ($request->bill_date_from != null && $request->bill_date_to != null)
                $bills = $bills->whereBetween('date', [$request->bill_date_from, $request->bill_date_to]);
        }
        if ($request->has('user_id')) {
            if ($request->user_id != null)
                $bills = $bills->where('user_id', ["$request->user_id"]);
        }
        if ($request->has('status')) {
            if ($request->status != null)
                $bills = $bills->where('status', ["$request->status"]);
        }
        if ($request->has('discount_in')) {
            if ($request->discount_in != null)
                $bills = $bills->where('discount_in', ["$request->discount_in"]);
        }
        $bills = $bills->when($request->has('invoice_no_min') && !is_null($request->invoice_no_min), function ($query) use ($request) {
            $query->where('invoice_no', '>=', $request->invoice_no_min);
        })
            ->when($request->has('invoice_no_max') && !is_null($request->invoice_no_max), function ($query) use ($request) {
                $query->where('invoice_no', '<=', (int)$request->invoice_no_max);
            });
        $bills = $bills->when($request->has('discount_min') && !is_null($request->discount_min), function ($query) use ($request) {
            $query->where('discount', '>=', $request->discount_min);
        })
            ->when($request->has('discount_max') && !is_null($request->discount_max), function ($query) use ($request) {
                $query->where('discount', '<=', (int)$request->discount_max);
            });
        $bills = $bills->when($request->has('vat_min') && !is_null($request->vat_min), function ($query) use ($request) {
            $query->where('vat', '>=', $request->vat_min);
        })
            ->when($request->has('vat_max') && !is_null($request->vat_max), function ($query) use ($request) {
                $query->where('vat', '<=', (int)$request->vat_max);
            });

        $bills = $bills->when($request->has('total_min') && !is_null($request->total_min), function ($query) use ($request) {
            $query->where('total', '>=', $request->total_min);
        })
            ->when($request->has('total_max') && !is_null($request->total_max), function ($query) use ($request) {
                $query->where('total', '<=', (int)$request->total_max);
            });
        $bills = $bills->when($request->has('net_total_min') && !is_null($request->net_total_min), function ($query) use ($request) {
            $query->where('net_total', '>=', $request->net_total_min);
        })
            ->when($request->has('net_total_max') && !is_null($request->net_total_max), function ($query) use ($request) {
                $query->where('net_total', '<=', (int)$request->net_total_max);
            });
        $bills = $bills->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });
        $bills = $bills->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });
        $bills = $bills->with('customer', 'user', 'sale')->orderBy('date')->get();
        $company = Company::findOrFail(1);
        $pdf = PDF::loadView('pdf.list-bill-pdf', compact('bills', 'company'));
        return $pdf->setPaper('A4','landscape')->stream("bill-" . now() . ".pdf");
    }
}
