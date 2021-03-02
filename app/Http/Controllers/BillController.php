<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use App\Models\User;
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
        $customers = Customer::get();
        $users = User::get();
        $bills = Bill::with('customer', 'user', 'sale')->latest()->paginate(20);
        return view('bill.index', compact('bills', 'customers', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer, Sale $sale = null, Bill $bill)
    {
        // $bill=Bill::where('uuid',$bill)->firstOrFail();

        $stores = Store::with('product', 'category', 'brand', 'unit')->where('quantity', '>', 0)->latest()->get();
        if (!$sale) {
            $sale = new Sale;
        }
        $sales = Sale::with('store', 'unit', 'product')->where('customer_id', $customer->id)->where('bill_id', $bill->id)->get();
        $net_tatal = 0;
        foreach ($sales as $total) {
            $net_tatal = $net_tatal + $total->total;
        }
        return view('bill.create', compact('customer', 'bill', 'sale', 'stores', 'sales', 'net_tatal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer)
    {
        $bill = Bill::create([
            'customer_id' => $customer->id,
            'user_id' => Auth::user()->id,
            'status' => 'incomplete',
        ]);
        return redirect()->route('bills.create', compact('customer', 'bill'))->with('success', 'New Bill Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        $saleDues = $bill->saleDeu()->latest()->paginate();
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
        $due = $request->net_total - $request->payment;
        $bill->update([
            'date' => $request->date,
            'invoice_no' => ++$invoice_no,
            'net_total' => $request->net_total,
            'payment' => $request->payment,
            'due' => $due,
            'status' => 'complete',
            'user_id' => Auth::user()->id,
        ]);
        $bill->sale()->update([
            'date' => $request->date,
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
        $bills = $bills->when($request->has('invoice_no_min') && !is_null($request->invoice_no_min), function ($query) use ($request) {
            $query->where('invoice_no', '>=', $request->invoice_no_min);
        })
            ->when($request->has('invoice_no_max') && !is_null($request->invoice_no_max), function ($query) use ($request) {
                $query->where('invoice_no', '<=', (int)$request->invoice_no_max);
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
        $bills = $bills->with('customer', 'user', 'sale')->latest()->paginate();
        return view('bill.index', compact('bills', 'customers', 'users'));
    }
}
