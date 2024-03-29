<?php

namespace App\Http\Controllers;

use App\Exports\purchaseExport;
use App\Http\Requests\PurchaseRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Company;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseBill;
use App\Models\Store;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade as PDF;
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
        $purchaseBills =  PurchaseBill::get();
        $total = 0;
        $quantity = 0;
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
            $quantity = $quantity + $purchase->quantity;
        }
        $purchases = Purchase::with('dealer', 'product', 'category', 'brand', 'unit','purchaseBill')->latest()->paginate(200);
        return view('purchase.index', compact('purchases', 'dealers', 'products', 'categories', 'brands', 'units', 'total', 'quantity','purchaseBills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Dealer $dealer)
    {
        $products = Product::get();
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        return view('purchase.create', compact('dealer', 'products', 'categories', 'brands', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request, PurchaseBill $purchaseBill)
    {
        $data = $request->validated();
        $total = $data['quantity'] * $data['rate'];
        if ($request->discount_in != "fixed") {
            $total = $total - $total * $data['discount'] / 100;
        } else {
            $total = $total -  $data['discount'];
        }
        $total = $total + $total * $data['vat'] / 100;
        $purchaseBill->purchase()->create([
            'dealer_id' => $purchaseBill->dealer_id,
            'product_id' => $data['product_id'],
            'batch_no' => $data['batch_no'],
            'mf_date' => $data['mf_date'],
            'exp_date' => $data['exp_date'],
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'rate' => $data['rate'],
            'discount_in' => $data['discount_in'],
            'discount' => $data['discount'],
            'vat' => $data['vat'],
            'total' => $total,
            'mrp' => $data['mrp'],
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
    public function show(Dealer $dealer)
    {
        $purchases = $dealer->purchase()->latest()->paginate();
        return view('purchase.show', compact('purchases', 'dealer'));
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
        $total = $data['quantity'] * $data['rate'];
        $total = $total - $total * $data['discount'] / 100;
        $total = $total + $total * $data['vat'] / 100;
        $due = $total - $data['payment'];
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
            'batch_no' => $data['batch_no'],
            'mf_date' => $data['mf_date'],
            'exp_date' => $data['exp_date'],
            'quantity' => $data['quantity'],
            'unit_id' => $data['unit_id'],
            'rate' => $data['rate'],
            'discount' => $data['discount'] ?? '0',
            'vat' => $data['vat'] ?? '0',
            'total' => $total,
            'payment' => $data['payment'],
            'due' => $due,
            'mrp' => $data['mrp'] ?? '0',
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
        $store = Store::where('product_id', $purchase->product_id)->where('batch_no',$purchase->batch_no)->where('mf_date',$purchase->mf_date)->where('exp_date', $purchase->exp_date)->first();
        $quantity = $store->quantity - $purchase->quantity;
        if($quantity <= 0){
            $quantity = 0;
           }
        $store->update([
            'quantity' => $quantity,
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
        return redirect()->route('purchase-bills.store', $dealer);
    }
    public function search(Request $request)
    {
      
        $purchases = new Purchase;
        if ($request->has('dealer_id')) {
            if ($request->dealer_id != null)
                $purchases = $purchases->where('dealer_id', ["$request->dealer_id"]);
        }
        if ($request->has('purchaseBill_id')) {
            if ($request->purchaseBill_id != null)
                $purchases = $purchases->where('purchase_bill_id', ["$request->purchaseBill_id"]);
        }
        if ($request->has('product_id')) {
            if ($request->product_id != null)
                $purchases = $purchases->where('product_id', ["$request->product_id"]);
        }
        if ($request->has('batch_no')) {
            if ($request->batch_no != null)
                $purchases = $purchases->where('batch_no', ["$request->batch_no"]);
        }
        if ($request->has('discount_in')) {
            if ($request->discount_in != null)
                $purchases = $purchases->where('discount_in', ["$request->discount_in"]);
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
            
        $purchases = $purchases->when($request->has('mrp_min') && !is_null($request->mrp_min), function ($query) use ($request) {
            $query->where('mrp', '>=', $request->mrp_min);
        })
            ->when($request->has('mrp_max') && !is_null($request->mrp_max), function ($query) use ($request) {
                $query->where('mrp', '<=', (int)$request->mrp_max);
            });

        $purchases = $purchases->with('dealer', 'product', 'category', 'brand', 'unit','purchaseBill')->paginate(10000);
        $total = 0;
        $quantity = 0;
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
            $quantity = $quantity + $purchase->quantity;
        }
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $dealers = Dealer::orderBy('name')->get();
        $purchaseBills =  PurchaseBill::get();
        return view('purchase.index', compact('purchases','purchaseBills', 'dealers', 'products', 'categories', 'brands', 'units', 'total', 'quantity'));
    }

    public function report(Request $request)
    {
      
        $purchases = new Purchase;
        if ($request->has('dealer_id')) {
            if ($request->dealer_id != null)
                $purchases = $purchases->where('dealer_id', ["$request->dealer_id"]);
        }
        if ($request->has('purchaseBill_id')) {
            if ($request->purchaseBill_id != null)
                $purchases = $purchases->where('purchase_bill_id', ["$request->purchaseBill_id"]);
        }
        if ($request->has('product_id')) {
            if ($request->product_id != null)
                $purchases = $purchases->where('product_id', ["$request->product_id"]);
        }
        if ($request->has('batch_no')) {
            if ($request->batch_no != null)
                $purchases = $purchases->where('batch_no', ["$request->batch_no"]);
        }
        if ($request->has('discount_in')) {
            if ($request->discount_in != null)
                $purchases = $purchases->where('discount_in', ["$request->discount_in"]);
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
            
        $purchases = $purchases->when($request->has('mrp_min') && !is_null($request->mrp_min), function ($query) use ($request) {
            $query->where('mrp', '>=', $request->mrp_min);
        })
            ->when($request->has('mrp_max') && !is_null($request->mrp_max), function ($query) use ($request) {
                $query->where('mrp', '<=', (int)$request->mrp_max);
            });

        $purchases = $purchases->with('dealer', 'product', 'category', 'brand', 'unit','purchaseBill')->get();
        $total = 0;
        $quantity = 0;
        foreach ($purchases as $purchase) {
            $total = $total + $purchase->total;
            $quantity = $quantity + $purchase->quantity;
        }
        $company = Company::findOrFail(1);
        $pdf = PDF::loadView('pdf.purchase-list-pdf', compact('purchases', 'company','total'));
        return $pdf->setPaper('A4','landscape')->stream("purchase-" . now() . ".pdf");
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
