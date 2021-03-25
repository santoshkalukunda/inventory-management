<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Unit;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = Store::get();
        $stores=Store::with('product', 'category', 'brand', 'unit')->latest()->paginate(200);
        $products = Product::with('category', 'brand',)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view('store.index',compact('stores','categories','products' ,'brands', 'units'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }

    public function search(Request $request)
    {
        $stores=new Store;
        if ($request->has('product_id')) {
            if ($request->product_id != null)
                $stores = $stores->where('product_id', ["$request->product_id"]);
        }
        $stores = $stores->when($request->has('quantity_min') && !is_null($request->quantity_min), function ($query) use ($request) {
            $query->where('quantity', '>=', $request->quantity_min);
        })
            ->when($request->has('quantity_max') && !is_null($request->quantity_max), function ($query) use ($request) {
                $query->where('quantity', '<=', (int)$request->quantity_max);
            });

        if ($request->has('unit_id')) {
            if ($request->unit_id != null)
                $stores = $stores->where('unit_id', "$request->unit_id");
        }
        if ($request->has('batch_no')) {
            if ($request->batch_no != null)
                $stores = $stores->where('batch_no', ["$request->batch_no"]);
        }
        if ($request->has('mf_date_from')) {
            if ($request->mf_date_from != null && $request->mf_date_to != null)
                $stores = $stores->whereBetween('mf_date', [$request->mf_date_from, $request->mf_date_to]);
        }
        if ($request->has('exp_date_from')) {
            if ($request->exp_date_from != null && $request->exp_date_to != null)
                $stores = $stores->whereBetween('exp_date', [$request->exp_date_from, $request->exp_date_to]);
        }

        $stores = $stores->when($request->has('mrp_min') && !is_null($request->mrp_min), function ($query) use ($request) {
            $query->where('mrp', '>=', $request->mrp_min);
        })
            ->when($request->has('mrp_max') && !is_null($request->mrp_max), function ($query) use ($request) {
                $query->where('mrp', '<=', (int)$request->mrp_max);
            });
            $stores = $stores->with('product', 'category', 'brand', 'unit')->paginate(1000);
            $products = Product::with('category', 'brand',)->orderBy('name')->get();
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $units = Unit::orderBy('name')->get();
            return view('store.index',compact('stores','categories','products' ,'brands', 'units'));
    }
}
