@extends('layouts.backend')
@section('title')
Inventories Product List
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
                            <div class="col-md-3 form-group">
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
                                    </span>">
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="quantity_min">Quantity Minimun</label>
                                <input type="number" min="0" step="any"
                                    class="form-control text-right @error('quantity_min') is-invalid @enderror"
                                    name="quantity_min" id="quantity_min" placeholder="Quantity Min">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="quantity_max">Quantity Maximum</label>
                                <input type="number" min="0" step="any"
                                    class="form-control text-right @error('quantity_max') is-invalid @enderror"
                                    name="quantity_max" id="quantity_max" placeholder="Quantity Max">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="unit_id">Unit</label>
                                <select class="selectpicker form-control @error('unit_id') is-invalid @enderror"
                                    name="unit_id" id="unit_id" data-live-search="true" data-size="5">
                                    <option value="" selected>Select Unit</option>
                                    @foreach ($units as $unit)
                                    <option value="{{$unit->id}}">
                                        {{$unit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="batch_no">Batch No.</label>
                                <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no"
                                    id="batch_no" placeholder="Batch No.">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="mf_date_from">Manufacture Date From</label>
                                <input type="date" class="form-control @error('mf_date_from') is-invalid @enderror"
                                    name="mf_date_from" id="mf_date_from">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="mf_date_to">Manufacture Date to</label>
                                <input type="date" class="form-control @error('mf_date_to') is-invalid @enderror"
                                    name="mf_date_to" id="mf_date_to">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="exp_date_from"> Expiry Date From</label>
                                <input type="date" class="form-control @error('exp_date_from') is-invalid @enderror"
                                    name="exp_date_from" id="exp_date_from">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="exp_date_to"> Expiry Date To</label>
                                <input type="date" class="form-control @error('exp_date_to') is-invalid @enderror"
                                    name="exp_date_to" id="exp_date_to">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="mrp_min">MRP Min.</label>
                                <input type="number" min="0"
                                    class="form-control text-right @error('mrp_min') is-invalid @enderror"
                                    name="mrp_min" id="mrp_min" placeholder="MRP Min.">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="mrp_max">MRP Max.</label>
                                <input type="number" min="0"
                                    class="form-control text-right @error('mrp_max') is-invalid @enderror"
                                    name="mrp_max" id="mrp_max" placeholder="MRP Max.">
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
            <div class="ibox-head d-flex">
                <div class="ibox-title">Inventories Product List</div>
                <div>Total Result: {{$stores->total()}}</div>
            </div>
            <div class="ibox-body table-responsive">
                <div class="table-responsive">
                    <table class="table-hover table">
                        <thead class="">
                            <tr class="bg-light">
                                <th>Product Name</th>
                                <th class="text-right">Quantity</th>
                                <th>Batch_No.</th>
                                <th>Manufacture_date</th>
                                <th>Expiry_date</th>
                                <th>MRP</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stores as $store)
                            <tr style="white-space:nowrap;">
                                <td>
                                    {{$store->product->code}}<br>
                                    <b>{{$store->product->name}}</b> <br>
                                    {{$store->product->category->name}} <br>
                                    {{$store->product->brand->name}} <br>
                                    {{$store->product->model_no}}
                                </td>
                                <td class="text-right">{{$store->quantity}} {{$store->unit->name}}</td>
                                <td class=" text-center">{{$store->batch_no}}</td>
                                <td>{{$store->mf_date}}</td>
                                <td>{{$store->exp_date}}</td>
                                <td class="text-right">{{$store->mrp}}</td>
                                {{-- <td>
                                    <a href="{{ route('stores.edit', $product) }}" class="text-muted"><i
                                    class="fa fa-edit"></i></a>
                                <span class="mx-3">|</span>
                                <form action="{{route('stores.destroy', $product) }}"
                                    onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
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
            </div>
        </div>
    </div>
    {{$stores->links()}}
</div>
@endsection