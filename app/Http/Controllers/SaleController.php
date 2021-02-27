<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use Illuminate\Http\Request;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sale.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer, Sale $sale = null)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleRequest $request, Customer $customer, Bill $bill)
    {
        $store = Store::where('id', $request->store_id)->first();
        if ($store->quantity >= $request->quantity) {
            $total_cost = $request->quantity * $request->rate;
            $total =  $total_cost -  ($total_cost * ($request->discount / 100));
            $total = $total + ($total * ($request->vat / 100));
            Sale::create([
                'customer_id' => $customer->id,
                'bill_id' => $bill->id,
                'store_id' => $request->store_id,
                'quantity' => $request->quantity,
                'unit_id' => $request->unit_id,
                'rate' => $request->rate,
                'total_cost' => $total_cost,
                'discount' => $request->discount ?? "0",
                'vat' => $request->vat ?? "0",
                'total' => $total,
            ]);
            $store->update([
                'quantity' => $store->quantity - $request->quantity,
            ]);
            return redirect()->back()->with('success', "Product Added Success");
        } else {
            return redirect()->back()->with('error', "Product quantity not enough");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $stores = Store::with('product', 'category', 'brand', 'unit')->where('quantity', '>', 0)->latest()->get();
        return view('sale.edit', compact('sale', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|numeric',
            'rate'=> 'required|numeric',
            'discount' => 'nullable|numeric',
            'vat' => 'nullable|numeric',
        ]);
        
        $store = Store::where('id', $sale->store_id)->first();

        if ($store->quantity >= $request->quantity) {
            $total_cost = $request->quantity * $request->rate;
            $total =  $total_cost -  ($total_cost * ($request->discount / 100));
            $total = $total + ($total * ($request->vat / 100));

            $store->update([
                'quantity' => $store->quantity + $sale->quantity - $request->quantity,   
            ]);

            $sale->update([
                'quantity' => $request->quantity,
                'rate' => $request->rate,
                'total_cost' => $total_cost,
                'discount' => $request->discount,
                'vat' => $request->vat,
                'total' => $total,
            ]);
            $customer = Customer::where('id',$sale->customer_id)->first();
            $bill = Bill::where('id',$sale->bill_id)->first();
            return redirect()->route('bills.create', compact('customer','bill'))->with('success', "Product Updated Success");
        } else {
            return redirect()->back()->with('error', "Product quantity not enough");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $store = Store::findOrFail($sale->store_id);
        $store->update([
            'quantity' => $store->quantity + $sale->quantity,
        ]);
        $sale->delete();
        return redirect()->back()->with('success', "Product Item deleted");
    }
}
