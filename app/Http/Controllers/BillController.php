<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Store;
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
        $bills=Bill::with('customer','user','sale')->latest()->paginate(20);
        return view('bill.index',compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer, Sale $sale=null, Bill $bill )
    {
        // $bill=Bill::where('uuid',$bill)->firstOrFail();
        
        $stores=Store::with('product', 'category', 'brand', 'unit')->where('quantity','>',0)->latest()->get();
        if (!$sale) {
            $sale = new Sale;
        }
        $sales=Sale::with('store','unit','product')->where('customer_id',$customer->id)->where('bill_id',$bill->id)->get();
        $net_tatal=0;
        foreach($sales as $total){
            $net_tatal= $net_tatal + $total->total;
        }
        return view('bill.create',compact('customer','bill','sale','stores','sales','net_tatal'));
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
        return redirect()->route('bills.create', compact('customer','bill'))->with('success', 'Customer Registration Successfull');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        //
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
        $invoice_no=Bill::max('invoice_no');
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
        return redirect()->back()->with('success',"Pyament Successfull");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bill $bill)
    {
        $bill->update([
            'status' => 'cancel',
        ]);
        $sales=Sale::where('bill_id',$bill->id)->where('customer_id',$bill->customer_id)->get();
        foreach($sales as $sale){
            $store = Store::findOrFail($sale->store_id);
            $store->update([
                'quantity' => $store->quantity + $sale->quantity,
            ]);
        }
        return redirect()->back()->with('success',"Bill cancel Successfull");
    }
}
