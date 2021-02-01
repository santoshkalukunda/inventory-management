@extends('layouts.backend')
@section('title')
Product
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
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
                    <div class="form-group">
                        <label for="code">Product Code</label>
                        <input type="text" id="code" name="code"
                            class="form-control @error('code') is-invalid @enderror" value="{{old('code',$product->code)}}"
                            placeholder="Product code">
                        @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-success form-control btn-rounded">{{$product->id ? "upadete" : "Add"}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="mb-2">
            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button"
                    aria-expanded="false" aria-controls="filter">
                    <i class="fa fa-filter"></i> Filter
                </a>
            </p>
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('products.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <input type="text" class=" form-control" name="code" placeholder="Product Code">
                            </div>
                            <div class="col-md-5 form-group">
                                <input type="text" class=" form-control" name="name" placeholder="Product Name">
                            </div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{$product->code}}</td>
                            <td>{{$product->name}}</td>
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
                            <td colspan="40" class="text-danger text-center"><span >OOPS!! data Not Found !!!</span></td>
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