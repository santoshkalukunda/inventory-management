<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseDueRequest;
use App\Models\Dealer;
use App\Models\Purchase;
use App\Models\PurchaseDue;
use App\Models\SaleDue;
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
        $dealers = Dealer::get();
        $purchaseDues = PurchaseDue::latest()->paginate(20);
        return view('purchase-due.index', compact('purchaseDues', 'dealers'));
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
        $purchaseDue = PurchaseDue::create([
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
        return redirect()->back()->with('success', "Due payment Successfull");
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
        $purchase = Purchase::findOrFail($purchaseDue->purchase_id);
        $purchase->update([
            'payment' => $purchase->payment - $purchaseDue->payment,
            'due' => $purchase->due + $purchaseDue->payment,
        ]);
        $purchaseDue->delete();
        return redirect()->back()->with('success', "Deu payment deleted");
    }

    public function search(Request $request)
    {
        $purchaseDues = new PurchaseDue;
        if ($request->has('dealer_id')) {
            if ($request->dealer_id != null)
                $purchaseDues = $purchaseDues->where('dealer_id', ["$request->dealer_id"]);
        }
        if ($request->has('bill_date_from')) {
            if ($request->bill_date_from != null && $request->bill_date_to != null)
                $purchaseDues = $purchaseDues->whereBetween('date', [$request->bill_date_from, $request->bill_date_to]);
        }
        $purchaseDues = $purchaseDues->when($request->has('net_total_min') && !is_null($request->net_total_min), function ($query) use ($request) {
            $query->where('due_amount', '>=', $request->net_total_min);
        })
            ->when($request->has('net_total_max') && !is_null($request->net_total_max), function ($query) use ($request) {
                $query->where('due_amount', '<=', (int)$request->net_total_max);
            });
        $purchaseDues = $purchaseDues->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });
        $purchaseDues = $purchaseDues->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });

            $dealers = Dealer::get();
            $purchaseDues = $purchaseDues->latest()->paginate();
            return view('purchase-due.index', compact('purchaseDues', 'dealers'));
    }
}
