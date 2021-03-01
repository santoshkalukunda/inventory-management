<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleDueRequest;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\SaleDue;
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
        //
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
    public function store(SaleDueRequest $request, Customer $customer, Bill $bill)
    {
        $due = $bill->due - $request->payment;
        $saleDue=SaleDue::create([
            'customer_id' => $customer->id,
            'bill_id' => $bill->id,
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
}
