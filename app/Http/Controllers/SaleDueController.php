<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleDueRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\SaleDue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleDueController extends Controller
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
        $saleDues = SaleDue::with('customer','bill','user')->latest()->paginate(20);
        return view('sale-due.index',compact('saleDues','customers','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleDueRequest $request, Bill $bill)
    {
        $due = $bill->due - $request->payment;
        $bill->saleDue()->create([
            'customer_id' => $bill->customer_id,
            'date' => $request->date,
            'due_amount' => $bill->due,
            'payment' => $request->payment,
            'due' =>  $due,
            'user_id' => Auth::user()->id,
        ]);
        $bill->update([
            'payment' => $bill->payment + $request->payment,
            'due' => $bill->due - $request->payment,
        ]);
        return redirect()->back()->with('success',"Deu Payment Successfull");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleDue  $saleDue
     * @return \Illuminate\Http\Response
     */
    public function show(SaleDue $saleDue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleDue  $saleDue
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleDue $saleDue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleDue  $saleDue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleDue $saleDue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleDue  $saleDue
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleDue $saleDue)
    {
        $bill=Bill::findOrFail($saleDue->bill_id);
        $bill->update([
            'payment' => $bill->payment - $saleDue->payment,
            'due' => $bill->due + $saleDue->payment,
        ]);
        $saleDue->delete();
        return redirect()->back()->with('success',"Deu payment deleted");
    }

    public function search(Request $request){
        $saleDues = new SaleDue;
        if ($request->has('customer_id')) {
            if ($request->customer_id != null)
                $saleDues = $saleDues->where('customer_id', ["$request->customer_id"]);
        }
        if ($request->has('bill_date_from')) {
            if ($request->bill_date_from != null && $request->bill_date_to != null)
                $saleDues = $saleDues->whereBetween('date', [$request->bill_date_from, $request->bill_date_to]);
        }
        if ($request->has('user_id')) {
            if ($request->user_id != null)
                $saleDues = $saleDues->where('user_id', ["$request->user_id"]);
        }
        $saleDues = $saleDues->when($request->has('net_total_min') && !is_null($request->net_total_min), function ($query) use ($request) {
            $query->where('due_amount', '>=', $request->net_total_min);
        })
            ->when($request->has('net_total_max') && !is_null($request->net_total_max), function ($query) use ($request) {
                $query->where('due_amount', '<=', (int)$request->net_total_max);
            });
        $saleDues = $saleDues->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });
        $saleDues = $saleDues->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });
        $customers = Customer::get();
        $users = User::get();
        $saleDues = $saleDues->with('customer','bill','user')->latest()->paginate();
        return view('sale-due.index',compact('saleDues','customers','users'));

    }
}
