<?php

namespace App\Http\Controllers;

use App\Exports\purchaseExport;
use App\Http\Requests\PurchaseRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Store;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $dealers = Dealer::orderBy('name')->get();
        $purchases = Purchase::with('dealer', 'product', 'category', 'brand', 'unit')->get();
        $total = 0;
        $due = 0;
        $payment = 0;
        $quantity = 0;
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
            $due = $due + $purchase->due;
            $payment = $payment + $purchase->payment;
            $quantity = $quantity + $purchase->quantity;
        }
        $purchases = Purchase::with('dealer', 'product', 'category', 'brand', 'unit')->latest()->paginate(200);
        return view('purchase.index', compact('purchases', 'dealers', 'products', 'categories', 'brands', 'units', 'total', 'due', 'payment', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer, Purchase $purchase = null)
    {
        if (!$purchase) {
            $purchase = new Purchase;
        }
        $products = Product::get();
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        return view('purchase.create', compact('purchase', 'dealer', 'products', 'categories', 'brands', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request, Dealer $dealer)
    {
        $data = $request->validated();
        // $purchase = new Purchase($request->validated());
        // $dealer->purchase()->save($purchase);
        $total = $data['quantity'] * $data['rate'];
        $total = $total - $total * $data['discount'] / 100;
        $total = $total + $total * $data['vat'] / 100;
        $due = $total - $data['payment'];

        Purchase::create([
            'order_date' => $data['order_date'],
            'shipping_date' => $data['shipping_date'],
            'bill_no' => $data['bill_no'],
            'dealer_id' => $dealer->id,
            'product_id' => $data['product_id'],
            'batch_no' => $data['batch_no'] ?? '-',
            'mf_date' => $data['mf_date'] ?? '-',
            'exp_date' => $data['exp_date'] ?? '-',
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'rate' => $data['rate'],
            'discount' => $data['discount'] ?? '0',
            'vat' => $data['vat'] ?? '0',
            'total' => $total,
            'payment' => $data['payment'],
            'due' => $due,
            'mrp' => $data['mrp'],
            'details' => $data['details'],
        ]);
        $store = Store::where('product_id', $data['product_id'])->where('batch_no', $data['batch_no'])->where('mf_date', $data['mf_date'])->where('exp_date', $data['exp_date'])->first();
        if ($store) {
            $total = $store->quantity + $data['quantity'];
            $store->update([
                'quantity' => $total,
                'unit_id' => $data['unit_id'],
                'batch_no' => $data['batch_no'],
                'mf_date' => $data['mf_date'],
                'exp_date' => $data['exp_date'],
                'mrp' => $data['mrp'],
            ]);
        } else {
            Store::create([
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity'],
                'unit_id' => $data['unit_id'],
                'batch_no' => $data['batch_no'],
                'mf_date' => $data['mf_date'],
                'exp_date' => $data['exp_date'],
                'mrp' => $data['mrp'],
            ]);
        }
        return redirect()->back()->with('success', 'Product Purchase done');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchaseDues = $purchase->purchaseDue()->latest()->paginate();
        return view('purchase.show', compact('purchase', 'purchaseDues'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $products = Product::get();
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        $dealer = Dealer::get();
        return view('purchase.edit', compact('purchase', 'dealer', 'products', 'categories', 'brands', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        $data = $request->validated();
        // $total = $data['quantity'] * $data['rate'] - (($data['quantity'] * $data['rate']) * $data['discount'] / 100) + (($data['quantity'] * $data['rate']) * $data['vat'] / 100);
        $total = $data['quantity'] * $data['rate'];
        $total = $total - $total * $data['discount'] / 100;
        $total = $total + $total * $data['vat'] / 100;
        $due = $total - $data['payment'];
        // $purchase->update($request->validated());
        if ($purchase->product_id == $data['product_id']) {
            $store = Store::where('product_id', $data['product_id'])->first();
            if ($purchase->quantity != $data['quantity']) {
                $total = $store->quantity + $data['quantity'] - $purchase->quantity;
                $store->update([
                    'quantity' => $total,
                    'unit_id' => $data['unit_id'],
                    'mrp' => $data['mrp'],
                ]);
            }
            if ($purchase->mrp != $data['mrp'] or $purchase->unit_id != $data['unit_id']) {

                $store->update([
                    'unit_id' => $data['unit_id'],
                    'mrp' => $data['mrp'],
                ]);
            }
        } else {
            $store = Store::where('product_id', $purchase->product_id)->first();
            $total = $store->quantity - $purchase->quantity;
            $store->update([
                'quantity' => $total,
            ]);
            $store = Store::where('product_id', $data['product_id'])->first();
            if ($store) {
                $total = $store->quantity + $data['quantity'];
                $store->update([
                    'quantity' => $total,
                    'unit_id' => $data['unit_id'],
                    'mrp' => $data['mrp'],
                ]);
            } else {
                Store::create([
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'unit_id' => $data['unit_id'],
                    'mrp' => $data['mrp'],
                ]);
            }
        }

        $purchase->update([
            'order_date' => $data['order_date'],
            'shipping_date' => $data['shipping_date'],
            'bill_no' => $data['bill_no'],
            'product_id' => $data['product_id'],
            // 'category_id' => $data['category_id'],
            // 'brand_id' => $data['brand_id'],
            // 'model_no' => $data['model_no'] ?? '-',
            // 'serial_no' => $data['serial_no'] ?? '-',
            'batch_no' => $data['batch_no'] ?? '-',
            'mf_date' => $data['mf_date'] ?? '-',
            'exp_date' => $data['exp_date'] ?? '-',
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'rate' => $data['rate'],
            'discount' => $data['discount'] ?? '0',
            'vat' => $data['vat'] ?? '0',
            'total' => $total,
            'payment' => $data['payment'],
            'due' => $due,
            'mrp' => $data['mrp'] ?? '-',
            'details' => $data['details'],
        ]);

        return redirect()->back()->with('success', 'Purchase Update Successfull');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $store = Store::where('product_id', $purchase->product_id)->first();
        $total = $store->quantity - $purchase->quantity;
        $store->update([
            'quantity' => $total,
        ]);
        $purchase->delete();
        return redirect()->back()->with('success', "Purchase product deleted");
    }

    public function find(Request $request)
    {
        $request->validate([
            'dealer_id' => 'required|exists:dealers,id',
        ]);
        $dealer = $request->dealer_id;
        return redirect()->route('purchase.create', $dealer);
    }
    public function search(Request $request)
    {
        $purchases = Purchase::get();
        $total = 0;
        $due = 0;
        $payment = 0;
        $quantity = 0;
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
            $due = $due + $purchase->due;
            $payment = $payment + $purchase->payment;
            $quantity = $quantity + $purchase->quantity;
        }
        $purchases = new Purchase;
        if ($request->has('dealer_id')) {
            if ($request->dealer_id != null)
                $purchases = $purchases->where('dealer_id', ["$request->dealer_id"]);
        }
        if ($request->has('bill_no')) {
            if ($request->bill_no != null)
                $purchases = $purchases->where('bill_no', ["$request->bill_no"]);
        }
        if ($request->has('product_id')) {
            if ($request->product_id != null)
                $purchases = $purchases->where('product_id', ["$request->product_id"]);
        }
        if ($request->has('batch_no')) {
            if ($request->batch_no != null)
                $purchases = $purchases->where('batch_no', ["$request->batch_no"]);
        }
        if ($request->has('order_date_from')) {
            if ($request->order_date_from != null && $request->order_date_to != null)
                $purchases = $purchases->whereBetween('order_date', [$request->order_date_from, $request->order_date_to]);
        }
        if ($request->has('shipping_date_from')) {
            if ($request->shipping_date_from != null && $request->shipping_date_to != null)
                $purchases = $purchases->whereBetween('shipping_date', [$request->shipping_date_from, $request->shipping_date_to]);
        }
        if ($request->has('mf_date_from')) {
            if ($request->mf_date_from != null && $request->mf_date_to != null)
                $purchases = $purchases->whereBetween('mf_date', [$request->mf_date_from, $request->mf_date_to]);
        }
        if ($request->has('exp_date_from')) {
            if ($request->exp_date_from != null && $request->exp_date_to != null)
                $purchases = $purchases->whereBetween('exp_date', [$request->exp_date_from, $request->exp_date_to]);
        }

        $purchases = $purchases->when($request->has('quantity_min') && !is_null($request->quantity_min), function ($query) use ($request) {
            $query->where('quantity', '>=', $request->quantity_min);
        })
            ->when($request->has('quantity_max') && !is_null($request->quantity_max), function ($query) use ($request) {
                $query->where('quantity', '<=', (int)$request->quantity_max);
            });

        if ($request->has('unit_id')) {
            if ($request->unit_id != null)
                $purchases = $purchases->where('unit_id', "$request->unit_id");
        }
        $purchases = $purchases->when($request->has('rate_min') && !is_null($request->rate_min), function ($query) use ($request) {
            $query->where('rate', '>=', $request->rate_min);
        })
            ->when($request->has('rate_max') && !is_null($request->rate_max), function ($query) use ($request) {
                $query->where('rate', '<=', (int)$request->rate_max);
            });

        $purchases = $purchases->when($request->has('discount_min') && !is_null($request->discount_min), function ($query) use ($request) {
            $query->where('discount', '>=', $request->discount_min);
        })
            ->when($request->has('discount_max') && !is_null($request->discount_max), function ($query) use ($request) {
                $query->where('discount', '<=', (int)$request->discount_max);
            });
        $purchases = $purchases->when($request->has('vat_min') && !is_null($request->vat_min), function ($query) use ($request) {
            $query->where('vat', '>=', $request->vat_min);
        })
            ->when($request->has('vat_max') && !is_null($request->vat_max), function ($query) use ($request) {
                $query->where('vat', '<=', (int)$request->vat_max);
            });

        $purchases = $purchases->when($request->has('total_min') && !is_null($request->total_min), function ($query) use ($request) {
            $query->where('total', '>=', $request->total_min);
        })
            ->when($request->has('total_max') && !is_null($request->total_max), function ($query) use ($request) {
                $query->where('total', '<=', (int)$request->total_max);
            });

        $purchases = $purchases->when($request->has('payment_min') && !is_null($request->payment_min), function ($query) use ($request) {
            $query->where('payment', '>=', $request->payment_min);
        })
            ->when($request->has('payment_max') && !is_null($request->payment_max), function ($query) use ($request) {
                $query->where('payment', '<=', (int)$request->payment_max);
            });

        $purchases = $purchases->when($request->has('due_min') && !is_null($request->due_min), function ($query) use ($request) {
            $query->where('due', '>=', $request->due_min);
        })
            ->when($request->has('due_max') && !is_null($request->due_max), function ($query) use ($request) {
                $query->where('due', '<=', (int)$request->due_max);
            });


        $purchases = $purchases->when($request->has('mrp_min') && !is_null($request->mrp_min), function ($query) use ($request) {
            $query->where('mrp', '>=', $request->mrp_min);
        })
            ->when($request->has('mrp_max') && !is_null($request->mrp_max), function ($query) use ($request) {
                $query->where('mrp', '<=', (int)$request->mrp_max);
            });

        $purchases = $purchases->with('dealer', 'product', 'category', 'brand', 'unit')->paginate(1000);
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $dealers = Dealer::orderBy('name')->get();
        return view('purchase.index', compact('purchases', 'dealers', 'products', 'categories', 'brands', 'units', 'total', 'due', 'payment', 'quantity'));
    }

    public function pdf()
    {
        $purchases = Purchase::get();
        $pdf = PDF::loadView('pdf.purchase-pdf', ['purchases' => $purchases]);
        return $pdf->setPaper('A4', 'landscape')->stream();
        // return $pdf->download('pdf.purchase-pdf/report.pdf');
    }

    public function exp()
    {
        return Excel::download(new purchaseExport, 'users-collection.xlsx');
    }
}
