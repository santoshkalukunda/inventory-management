@extends('layouts.backend')
@section('title')
Product
@endsection
@section('content')
<div class="row">
    <div class="col-md-2">
        <p>
            <a class="btn btn-primary" href="{{route('products.create')}}">
                <i class="fa fa-plus"></i> New Product
            </a>
        </p>
    </div>
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
                    <form action="{{route('products.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-3 form-group">
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
                        <h3 class="m-0">products List</h3>
                    </div>
                    <div class="col-md text-right">
                        <span>Total Record: {{$products->total()}}</span>
                    </div>
                </div>
                <hr>
                <table class="table table-hover">
                    <thead class="bg-dark-light">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model_No.</th>
                            <th>Serial_No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{$product->code}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->model_no}}</td>
                            <td>{{$product->serial_no}}</td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="text-muted"><i
                                        class="fa fa-edit"></i></a>
                                <span class="mx-3">|</span>
                                <form action="{{route('products.destroy', $product) }}"
                                    onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                            class="fa fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="40" class="text-danger text-center"><span>OOPS!! data Not Found !!!</span></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection