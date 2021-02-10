<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
        $brands = Brand::get();
        $products = Product::with('category', 'brand',)->latest()->paginate(20);
        return view('product.index', compact('products','brands','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        if (!$product) {
            $product = new Product;
        }
        $categories = Category::get();
        $brands = Brand::get();
        return view('product.create', compact('product', 'categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Product Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return $this->create($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted');
    }

    public function search(Request $request)
    {
        $products = new Product;
        if ($request->has('code')) {
            if ($request->code != null)
                $products = $products->where('code', 'LIKE', ["$request->code%"]);
        }
        if ($request->has('name')) {
            if ($request->name != null)
                $products = $products->where('name', 'LIKE', ["$request->name%"]);
        }
        if ($request->has('category_id')) {
            if ($request->category_id != null)
                $products = $products->where('category_id', ["$request->category_id"]);
        }
        if ($request->has('brand_id')) {
            if ($request->brand_id != null)
                $products = $products->where('brand_id', ["$request->brand_id"]);
        }
        if ($request->has('model_no')) {
            if ($request->model_no != null)
                $products = $products->where('model_no', ["$request->model_no"]);
        }
        if ($request->has('serial_no')) {
            if ($request->serial_no != null)
                $products = $products->where('serial_no', ["$request->serial_no"]);
        }
        $products = $products->with('category', 'brand',)->paginate();
        $categories = Category::get();
        $brands = Brand::get();
        return view('product.index', compact('products','categories','brands'));
    }
}
