@extends('layouts.backend')
@section('title')
Product
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Product Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{$product->id ? route('products.update',$product) : route('products.store')}}" method="post">
                    @csrf
                    @if ($product->id)
                    @method('put')
                    @endif
                    <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="code">Product Code</label>
                        <input type="text" id="code" name="code"
                            class="form-control @error('code') is-invalid @enderror" value="{{old('code',$product->code)}}"
                            placeholder="Product code" autofocus>
                        @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name',$product->name)}}"
                            placeholder="Product Name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class=" col-md-3 form-group">
                        <label for="category_id" class="required">Category Name</label>
                        <select  class="selectpicker form-control @error('category_id') is-invalid @enderror" name="category_id"   id="product_id" data-live-search="true" data-size="5">
                            <option value="" selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{$category->id == $product->category_id ? 'selected' : ''}}> {{$category->name}}</option>
                            @endforeach
                          </select>
                        @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class=" col-md-3 form-group">
                        <label for="brand_id" class="required">Brand Name</label>
                        <select  class="selectpicker form-control @error('brand_id') is-invalid @enderror" name="brand_id"   id="brand_id" data-live-search="true" data-size="5">
                            <option value="" selected>Select Brand</option>
                            @foreach ($brands as $brand)
                                <option value="{{$brand->id}}" {{$brand->id == $product->brand_id ? 'selected' : ''}}> {{$brand->name}}</option>
                            @endforeach
                          </select>
                        @error('brand_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class=" col-md-3 form-group">
                        <label for="model_no">Model No.</label>
                        <input type="text" class="form-control @error('model_no') is-invalid @enderror" name="model_no" value="{{old('model_no',$product->model_no)}}" id="model_no" placeholder="Model No.">
                        @error('model_no')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class=" col-md-3 form-group">
                        <label for="serial_no">Serial No.</label>
                        <input type="text" class="form-control @error('serial_no') is-invalid @enderror" name="serial_no" value="{{old('serial_no',$product->serial_no)}}" id="serial_no" placeholder="Model No.">
                        @error('serial_no')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-12 form-group">
                        <label for="details">Details.</label>
                        <textarea type="text" class="form-control @error('details') is-invalid @enderror" name="details" value="{{old('serial_no',$product->serial_no)}}" id="details" placeholder="Other Product details">{{$product->details}}</textarea>
                        @error('details')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <button type="submit"
                            class="btn btn-success form-control btn-rounded">{{$product->id ? "upadete" : "Add"}}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection