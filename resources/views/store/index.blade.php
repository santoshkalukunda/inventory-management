@extends('layouts.backend')
@section('title')
Inventories Product List
@endsection
@section('content')

<div class="row">
    <div class="col-md-1">
        <p>
            <a class="btn btn-primary" onclick="btn1()" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </p>
    </div>
    <div class="col-md-1">
        <p>
            <a class="btn btn-primary"  onclick="btn2()"  data-toggle="collapse" href="#report" role="button" aria-expanded="false"
                aria-controls="report">
                <i class="fa fa-file"></i> Reports
            </a>
        </p>
    </div>
    <div class="col-md-10 form-group text-right">
        <span class="bg-blue-light p-2"><b>Product Quantity: </b>{{$quantity}}</span>
        <span class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</span>
    </div>
    <div class="col-lg-12">
        {{-- filter-search --}}
        <div class="mb-2" id="demo">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('stores.search')}}" method="get">
                        @include('store.filter-input')
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- filter-search --}}
        <div class="mb-2" id="demo1">
            <div class="collapse" id="report">
                <div class="card card-body">
                    <form action="{{route('stores.pdf')}}" method="get">
                        @include('store.filter-input')
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Download PDF">
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stores as $store)
                            @php
                            $color ="";
                            if( $store->exp_date && $store->exp_date < date('Y-m-d')){ $color="table-danger" ; } elseif
                                ($store->exp_date && $store->exp_date <= now()->addDays(30)) {
                                    $color = "table-warning";
                                    }
                                    else {
                                    $color = "";
                                    }
                                    @endphp
                                    <tr style="white-space:nowrap;" class="{{$color}}">
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
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary fa fa-edit" data-toggle="modal"
                                                data-target="#staticBackdrop-{{$store->id}}" data-placement="top"
                                                title="Edit MRP">
                                            </button>

                                            @include('modal.mrp-edit')
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="40" class="text-danger text-center"><span>OOPS!! data Not Found
                                                !!!</span>
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
<script>
    function btn1() {
      var x = document.getElementById("demo1");
      x.style.display = "none";
      var x = document.getElementById("demo");
      x.style.display = "block";
    }
    function btn2() {
      var x = document.getElementById("demo");
      x.style.display = "none";
      var x = document.getElementById("demo1");
      x.style.display = "block";
    }
    </script>
@endsection