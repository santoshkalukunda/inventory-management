<?php

namespace App\Http\Controllers;

use App\Exports\purchaseExport;
use App\Http\Requests\PurchaseRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Purchase;
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
        $products = Product::get();
        $categories = Category::get();
        $brands = Brand::get();
        $units = Unit::get();
        $dealers = Dealer::get();
        $purchases = Purchase::with('dealer', 'product', 'category', 'brand', 'unit')->latest()->paginate(20);
        return view('purchase.index', compact('purchases', 'dealers', 'products', 'categories', 'brands', 'units'));
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
        $total=$data['quantity'] * $data['rate'] - (($data['quantity'] * $data['rate']) * $data['discount'] / 100) + (($data['quantity'] * $data['rate']) * $data['vat'] / 100);
        $due= $total-$data['payment'];
        
        Purchase::create([
            'order_date' => $data['order_date'],
            'shipping_date' => $data['shipping_date'],
            'bill_no' => $data['bill_no'],
            'dealer_id' => $dealer->id,
            'product_id' => $data['product_id'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'model_no' => $data['model_no'] ?? '-',
            'serial_no' => $data['serial_no'] ?? '-',
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
        //
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
        $total=$data['quantity'] * $data['rate'] - (($data['quantity'] * $data['rate']) * $data['discount'] / 100) + (($data['quantity'] * $data['rate']) * $data['vat'] / 100);
        $due= $total-$data['payment'];
        // $purchase->update($request->validated());
        $purchase->update([
            'order_date' => $data['order_date'],
            'shipping_date' => $data['shipping_date'],
            'bill_no' => $data['bill_no'],
            'product_id' => $data['product_id'],
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],
            'model_no' => $data['model_no'] ?? '-',
            'serial_no' => $data['serial_no'] ?? '-',
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
        $purchase->delete();
        return redirect()->back()->with('success', "Purchase product deleted");
    }

    public function find(Request $request){
        $request->validate([
            'dealer_id' => 'required|exists:dealers,id',
        ]);
        $dealer=$request->dealer_id;
        return redirect()->route('purchase.create',$dealer);
    }

    public function pdf(){
        $purchases=Purchase::get();
        $pdf = PDF::loadView('pdf.purchase-pdf',['purchases' => $purchases]);
        return $pdf->setPaper('A4', 'landscape')->stream();
        // return $pdf->download('pdf.purchase-pdf/report.pdf');
    }

    public function exp() {
        return Excel::download(new purchaseExport, 'users-collection.xlsx');
    }
}