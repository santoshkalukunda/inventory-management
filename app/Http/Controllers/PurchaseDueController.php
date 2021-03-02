<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseDueRequest;
use App\Models\Dealer;
use App\Models\Purchase;
use App\Models\PurchaseDue;
use Illuminate\Http\Request;

class PurchaseDueController extends Controller
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
    public function store(PurchaseDueRequest $request, Purchase $purchase)
    {

        $due = $purchase->due - $request->payment;
        $purchaseDue=PurchaseDue::create([
            'purchase_id' => $purchase->id,
            'dealer_id' => $purchase->dealer_id,
            'date' => $request->date,
            'due_amount' => $request->due_amount,
            'payment' => $request->payment,
            'due' => $due,
        ]);
        $purchase->update([
            'payment' => $purchase->payment + $request->payment,
            'due' => $due,
        ]);
        return redirect()->back()->with('success',"Due payment Successfull");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseDue  $purchaseDue
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseDue $purchaseDue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseDue  $purchaseDue
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDue $purchaseDue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseDue  $purchaseDue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseDue $purchaseDue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseDue  $purchaseDue
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseDue $purchaseDue)
    {
        $purchase=Purchase::findOrFail($purchaseDue->purchase_id);
        $purchase->update([
            'payment' => $purchase->payment - $purchaseDue->payment,
            'due' => $purchase->due + $purchaseDue->payment,
        ]);
        $purchaseDue->delete();
        return redirect()->back()->with('success',"Deu payment deleted");
    }
}
