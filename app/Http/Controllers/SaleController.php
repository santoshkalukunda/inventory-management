<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Unit;
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
        $sales=Sale::get();
        $total=0;
        $due=0;
        $payment=0;
        $quantity=0;
        foreach($sales as $sale)
        {
        $total=$total+$sale->total;
        $quantity=$quantity+$sale->quantity;
        }
        $customers = Customer::get();
        $stores = Store::get();
        $units = Unit::get();
        $sales=Sale::with('customer','store','bill','unit')->latest()->paginate(500);
        return view('sale.index',compact('sales','customers','stores','units','total','due','payment','quantity'));
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
    public function store(SaleRequest $request, Bill $bill)
    {
        $store = Store::where('id', $request->store_id)->where('id', $request->store_id)->first();
        if ($store->quantity >= $request->quantity) {
            $total_cost = $request->quantity * $request->rate;
            $total =  $total_cost -  ($total_cost * ($request->discount / 100));
            $total = $total + ($total * ($request->vat / 100));
            $bill->sale()->create([
                'customer_id' => $bill->customer_id,
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

    public function search(Request $request){
        $sales=Sale::get();
        $total=0;
        $due=0;
        $payment=0;
        $quantity=0;
        foreach($sales as $sale)
        {
        $total=$total+$sale->total;
        $quantity=$quantity+$sale->quantity;
        }
        $sales = new Sale;
        if ($request->has('customer_id')) {
            if ($request->customer_id != null)
                $sales = $sales->where('customer_id', ["$request->customer_id"]);
        }
        if ($request->has('store_id')) {
            if ($request->store_id != null)
                $sales = $sales->where('store_id', ["$request->store_id"]);
        }
        if ($request->has('bill_date_from')) {
            if ($request->bill_date_from != null && $request->bill_date_to != null)
                $sales = $sales->whereBetween('date', [$request->bill_date_from, $request->bill_date_to]);
        }
        $sales = $sales->when($request->has('invoice_no_min') && !is_null($request->invoice_no_min), function ($query) use ($request) {
            $query->where('invoice_no', '>=', $request->invoice_no_min);
        })
            ->when($request->has('invoice_no_max') && !is_null($request->invoice_no_max), function ($query) use ($request) {
                $query->where('invoice_no', '<=', (int)$request->invoice_no_max);
            });
        $sales = $sales->when($request->has('quantity_min') && !is_null($request->quantity_min), function ($query) use ($request) {
            $query->where('quantity', '>=', $request->quantity_min);
        })
            ->when($request->has('quantity_max') && !is_null($request->quantity_max), function ($query) use ($request) {
                $query->where('quantity', '<=', (int)$request->quantity_max);
            });

        if ($request->has('unit_id')) {
            if ($request->unit_id != null)
                $sales = $sales->where('unit_id', "$request->unit_id");
        }
        $sales = $sales->when($request->has('rate_min') && !is_null($request->rate_min), function ($query) use ($request) {
            $query->where('rate', '>=', $request->rate_min);
        })
            ->when($request->has('rate_max') && !is_null($request->rate_max), function ($query) use ($request) {
                $query->where('rate', '<=', (int)$request->rate_max);
            });
            $sales = $sales->when($request->has('total_cost_min') && !is_null($request->total_cost_min), function ($query) use ($request) {
                $query->where('total_cost', '>=', $request->total_cost_min);
            })
                ->when($request->has('total_cost_max') && !is_null($request->total_cost_max), function ($query) use ($request) {
                    $query->where('total_cost', '<=', (int)$request->total_cost_max);
                });
        $sales = $sales->when($request->has('discount_min') && !is_null($request->discount_min), function ($query) use ($request) {
            $query->where('discount', '>=', $request->discount_min);
        })
            ->when($request->has('discount_max') && !is_null($request->discount_max), function ($query) use ($request) {
                $query->where('discount', '<=', (int)$request->discount_max);
            });
        $sales = $sales->when($request->has('vat_min') && !is_null($request->vat_min), function ($query) use ($request) {
            $query->where('vat', '>=', $request->vat_min);
        })
            ->when($request->has('vat_max') && !is_null($request->vat_max), function ($query) use ($request) {
                $query->where('vat', '<=', (int)$request->vat_max);
            });

        $sales = $sales->when($request->has('total_min') && !is_null($request->total_min), function ($query) use ($request) {
            $query->where('total', '>=', $request->total_min);
        })
            ->when($request->has('total_max') && !is_null($request->total_max), function ($query) use ($request) {
                $query->where('total', '<=', (int)$request->total_max);
            });

            $customers = Customer::get();
            $stores = Store::get();
            $units = Unit::get();
            $sales = $sales->with('customer','store','bill','unit')->latest()->paginate(1000);
            return view('sale.index',compact('sales','customers','stores','units','total','due','payment','quantity')); 
    }
}
