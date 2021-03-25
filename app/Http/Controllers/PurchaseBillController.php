<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseBillRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseBill;
use App\Models\Sale;
use App\Models\Store;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseBillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseBills = PurchaseBill::get();
        $net_total = 0;
        $due = 0;
        $payment = 0;
        $quantity = 0;
        foreach ($purchaseBills as $purchaseBill) {
            $net_total = $net_total + $purchaseBill->net_total;
            $due = $due + $purchaseBill->due;
            $payment = $payment + $purchaseBill->payment;
            $quantity = $quantity + $purchaseBill->quantity;
        }
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $dealers = Dealer::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $purchaseBills = PurchaseBill::with('dealer', 'user')->latest()->paginate(200);
        return view('purchase-bill.index', compact('purchaseBills', 'dealers', 'products', 'net_total', 'due', 'payment', 'quantity', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(PurchaseBill $purchaseBill)
    {
        $total = 0;
        $payment = 0;
        $due = 0;
        $products = Product::get();
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        $purchases = $purchaseBill->purchase()->get();
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
        }
        $purchases = $purchaseBill->purchase()->with('dealer', 'product', 'category', 'brand', 'unit')->latest()->paginate();
        return view('purchase-bill.create', compact('purchaseBill', 'products', 'categories', 'brands', 'units', 'purchases', 'total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Dealer $dealer)
    {
        $puechaeBill = $dealer->purchaseBill()->create([
            'user_id' => Auth::user()->id,
            'status' => 'incomplete',
        ]);
        return redirect()->route('purchase-bills.create', $puechaeBill)->with('success', 'New Puchase Bill Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseBill  $purchaseBill
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseBill $purchaseBill)
    {
        $purchaseBillDues = $purchaseBill->purchaseDue()->latest()->paginate();
        return view('purchase-bill.show', compact('purchaseBill', 'purchaseBillDues'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseBill  $purchaseBill
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseBill $purchaseBill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseBill  $purchaseBill
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseBillRequest $request, PurchaseBill $purchaseBill)
    {
        $purchaseBill->update([
            "order_date" => $request->order_date,
            "shipping_date" => $request->shipping_date,
            "bill_no" => $request->bill_no,
            "total" => $request->total,
            "discount" => $request->discount,
            "vat" => $request->vat,
            "net_total" => $request->net_total,
            "payment" => $request->payment,
            "due" => $request->due,
            "status" => 'complete'
        ]);
        return redirect()->back()->with('success', 'Purchase bill pay success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseBill  $purchaseBill
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseBill $purchaseBill)
    {
        $purchases = $purchaseBill->purchase()->get();
        foreach ($purchases as $purchase) {
            $store = Store::where('product_id', $purchase->product_id)->where('batch_no', $purchase->batch_no)->where('mf_date', $purchase->mf_date)->where('exp_date', $purchase->exp_date)->first();
           $quantity = $store->quantity - $purchase->quantity;
           if($quantity <= 0){
            $quantity = 0;
           }
            $store->update([
                'quantity' => $quantity,
            ]);
            $purchase->delete();
        }
        $purchaseBill->delete();
        return redirect()->back()->with('success', 'Purchase bill Delete');
    }

    public function search(Request $request)
    {
        $purchaseBills = PurchaseBill::get();
        $net_total = 0;
        $due = 0;
        $payment = 0;
        $quantity = 0;
        foreach ($purchaseBills as $purchaseBill) {
            $net_total = $net_total + $purchaseBill->net_total;
            $due = $due + $purchaseBill->due;
            $payment = $payment + $purchaseBill->payment;
            $quantity = $quantity + $purchaseBill->quantity;
        }
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $dealers = Dealer::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        $purchaseBills = new PurchaseBill;
        if ($request->has('dealer_id')) {
            if ($request->dealer_id != null)
                $purchaseBills = $purchaseBills->where('dealer_id', ["$request->dealer_id"]);
        }
        if ($request->has('bill_no')) {
            if ($request->bill_no != null)
                $purchaseBills = $purchaseBills->where('bill_no', ["$request->bill_no"]);
        }
        if ($request->has('status')) {
            if ($request->status != null)
                $purchaseBills = $purchaseBills->where('status', ["$request->status"]);
        }
        if ($request->has('order_date_from')) {
            if ($request->order_date_from != null && $request->order_date_to != null)
                $purchaseBills = $purchaseBills->whereBetween('order_date', [$request->order_date_from, $request->order_date_to]);
        }
        if ($request->has('shipping_date_from')) {
            if ($request->shipping_date_from != null && $request->shipping_date_to != null)
                $purchaseBills = $purchaseBills->whereBetween('shipping_date', [$request->shipping_date_from, $request->shipping_date_to]);
        }
        if ($request->has('mf_date_from')) {
            if ($request->mf_date_from != null && $request->mf_date_to != null)
                $purchaseBills = $purchaseBills->whereBetween('mf_date', [$request->mf_date_from, $request->mf_date_to]);
        }
        if ($request->has('exp_date_from')) {
            if ($request->exp_date_from != null && $request->exp_date_to != null)
                $purchaseBills = $purchaseBills->whereBetween('exp_date', [$request->exp_date_from, $request->exp_date_to]);
        }
        $purchaseBills = $purchaseBills->when($request->has('discount_min') && !is_null($request->discount_min), function ($query) use ($request) {
            $query->where('discount', '>=', $request->discount_min);
        })
            ->when($request->has('discount_max') && !is_null($request->discount_max), function ($query) use ($request) {
                $query->where('discount', '<=', (int)$request->discount_max);
            });
        $purchaseBills = $purchaseBills->when($request->has('vat_min') && !is_null($request->vat_min), function ($query) use ($request) {
            $query->where('vat', '>=', $request->vat_min);
        })
            ->when($request->has('vat_max') && !is_null($request->vat_max), function ($query) use ($request) {
                $query->where('vat', '<=', (int)$request->vat_max);
            });

        $purchaseBills = $purchaseBills->when($request->has('total_min') && !is_null($request->total_min), function ($query) use ($request) {
            $query->where('total', '>=', $request->total_min);
        })
            ->when($request->has('total_max') && !is_null($request->total_max), function ($query) use ($request) {
                $query->where('total', '<=', (int)$request->total_max);
            });

        $purchaseBills = $purchaseBills->when($request->has('net_total_min') && !is_null($request->net_total_min), function ($query) use ($request) {
            $query->where('net_total', '>=', $request->net_total_min);
        })
            ->when($request->has('net_total_max') && !is_null($request->net_total_max), function ($query) use ($request) {
                $query->where('net_total', '<=', (int)$request->net_total_max);
            });

        $purchaseBills = $purchaseBills->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });

        $purchaseBills = $purchaseBills->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });
        $purchaseBills = $purchaseBills->with('dealer', 'user')->latest()->paginate(1000);
        return view('purchase-bill.index', compact('purchaseBills', 'dealers', 'products', 'net_total', 'due', 'payment', 'quantity', 'users'));
    }
}
