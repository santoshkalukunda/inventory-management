@extends('layouts.backend')
@section('title')
Product
@endsection
@section('content')
<div class="row">
    <div class="col-md-1">
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </p>
    </div>
    <div class="col-lg-12">
        <div class="mb-2">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('stores.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="product_id">Product Name</label>
                                <select class="selectpicker form-control @error('product_id') is-invalid @enderror"
                                    name="product_id" id="product" data-live-search="true" data-size="4">
                                    <option value="" selected>Select Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{$product->id}}" data-content="<span><b>{{$product->name}}</b>
                                        <br>{{$product->code}}
                                        <br>{{$product->category->name}}
                                        <br>{{$product->brand->name}}
                                        <br>{{$product->model_no}}
                                        <br>{{$product->serial_no}}
                                    </span>">    
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-3 form-group">
                                <label for="category_id">Prodcut Code</label>
                                <input type="text" class=" form-control" name="code" placeholder="Product Code">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="category_id">Prodcut Name</label>
                                <input type="text" class=" form-control" name="name" placeholder="Product Name">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="category_id">Category Name</label>
                                <select class="selectpicker form-control @error('category_id') is-invalid @enderror"
                                    name="category_id" id="product_id" data-live-search="true" data-size="5">
                                    <option value="" selected>Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}"> {{$category->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="brand_id">Brand Name</label>
                                <select class="selectpicker form-control @error('brand_id') is-invalid @enderror"
                                    name="brand_id" id="brand_id" data-live-search="true" data-size="5">
                                    <option value="" selected>Select Brand</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">
                                    {{$brand->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="model_no">Model No.</label>
                                <input type="text" class="form-control @error('model_no') is-invalid @enderror"
                                    name="model_no" id="model_no" placeholder="Model No.">

                            </div>
                            <div class="col-md-3 form-group">
                                <label for="serial_no">Serial No.</label>
                                <input type="text" class="form-control @error('serial_no') is-invalid @enderror"
                                    name="serial_no" id="serial_no" placeholder="Model No.">
                            </div> --}}
                            <div class="col-md-3 form-group">
                                <label for="quantity_min">Quantity Minimun</label>
                                <input type="number" min="0" step="any"
                                    class="form-control text-right @error('quantity_min') is-invalid @enderror"
                                    name="quantity_min" id="quantity_min" placeholder="Quantity Min">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="quantity_max">Quantity Maximum</label>
                                <input type="number" min="0" step="any"
                                    class="form-control text-right @error('quantity_max') is-invalid @enderror"
                                    name="quantity_max" id="quantity_max" placeholder="Quantity Max">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="unit_id">Unit</label>
                                <select class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id"
                                    id="unit_id" data-live-search="true" data-size="5">
                                    <option value="" selected>Select Unit</option>
                                    @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">
                                        {{$unit->name}}</option>
                                    @endforeach
                                </select>
        
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="mrp_min">MRP Min.</label>
                                <input type="number" min="0"
                                    class="form-control text-right @error('mrp_min') is-invalid @enderror" name="mrp_min"
                                    id="mrp_min" placeholder="MRP Min.">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="mrp_max">MRP Max.</label>
                                <input type="number" min="0"
                                    class="form-control text-right @error('mrp_max') is-invalid @enderror" name="mrp_max"
                                    id="mrp_max" placeholder="MRP Max.">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-body table-responsive">
                <div class="row">
                    <div class="col-md">
                        <h3 class="m-0">Products List</h3>
                    </div>
                    <div class="col-md text-right">
                        {{-- <span>Total Record: {{$products->total()}}</span> --}}
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table-hover table-bordered">
                        <thead class="">
                            <tr class="text-center bg-light">
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Model_No.</th>
                                <th>Serial_No.</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>MRP</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stores as $store)
                            <tr style="white-space:nowrap;">
                                <td>{{$store->product->code}}</td>
                                <td>{{$store->product->name}}</td>
                                <td>{{$store->product->category->name}}</td>
                                <td>{{$store->product->brand->name}}</td>
                                <td>{{$store->product->model_no}}</td>
                                <td>{{$store->product->serial_no}}</td>
                                <td class="text-right">{{$store->quantity}}</td>
                                <td> {{$store->unit->name}}</td>
                                <td class="text-right">{{$store->mrp}}</td>
                                {{-- <td>
                                    <a href="{{ route('stores.edit', $product) }}" class="text-muted"><i
                                        class="fa fa-edit"></i></a>
                                    <span class="mx-3">|</span>
                                    <form action="{{route('stores.destroy', $product) }}"
                                        onsubmit="return confirm('Are you sure to delete?')" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                                class="fa fa-trash-alt"></i></button>
                                    </form>
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="40" class="text-danger text-center"><span>OOPS!! data Not Found !!!</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- {{$stores->links()}} --}}
            </div>
        </div>
    </div>
</div>
@endsection