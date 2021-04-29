@extends('layouts.backend')
@section('title')
Sales List
@endsection
@section('content')
@push('style')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

<div class="row">
    <div class="col-md-2 form-group">
        <button class="btn btn-primary form-control" data-toggle="modal" data-target="#new-bill"> <i
                class="fa fa-plus"></i> New
            Sale
        </button>
        @include('modal.bill-create')
    </div>
    <div class="col-md-2 form-group">
        <a class="btn btn-primary form-control" onclick="btn1()" data-toggle="collapse" href="#filter" role="button"
            aria-expanded="false" aria-controls="filter">
            <i class="fa fa-filter"></i> Filter
        </a>
    </div>
    <div class="col-md-2 ">
        <a class="btn btn-primary form-control" onclick="btn2()" data-toggle="collapse" href="#report" role="button"
            aria-expanded="false" aria-controls="report">
            <i class="fa fa-file-pdf"></i> Reports
        </a>
    </div>
    <div class="col-md-6 d-flex  mt-lg-0 mt-3 justify-content-end my-2">
        <div class="bg-blue-light p-2"><b>Product Quantity: </b>{{$quantity}}</div>
        <div class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</div>
    </div>
    <div class="col-md-12 mb-2">

        {{-- filter-search --}}
        <div class="mb-2" id="demo">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('sales.search')}}" method="get">
                        @include('sale.filter-input')
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- report-generate --}}
        <div class="mb-2" id="demo1">
            <div class="collapse" id="report">
                <div class="card card-body">
                    <form action="{{route('sales.report')}}" method="get">
                        @include('sale.filter-input')
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Download PDF">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 justify-content-center">
        <div class="ibox">
            <div class="ibox-head d-flex">
                <div class="ibox-title">Sales List</div>
                <div>Total Result: {{$sales->total()}}</div>
            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table-hover table">
                        <tr class="text-center bg-light">
                            <th>Date</th>
                            <th>Invoice_No.</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Batch_No.</th>
                            <th>Mf_date</th>
                            <th>Exp._date</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Rate</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">TAX/VAT</th>
                            <th class="text-right">Net-Total</th>
                            <th colspan="3">Action</th>
                        </tr>
                        @forelse ($sales as $sale)
                        @php
                        if ($sale->bill->status == "incomplete"){
                        $color = "table-warning";
                        }
                        elseif($sale->bill->status == "cancel"){
                        $color = "table-danger";
                        }
                        else {
                        $color = "";
                        }
                        @endphp
                        <tr style="white-space:nowrap;" class="{{$color}}">
                            <td>{{$sale->date}}</td>
                            <td>{{$sale->invoice_no}}</td>
                            <td>
                                <b>{{$sale->customer->name}}</b></a>
                                <span class=""> <br>{{$sale->customer->address}}</span>
                                <span class=""> <br>{{$sale->customer->phone}}</span>
                                <span class=""> <br>{{$sale->customer->pan_vat}}</span>
                            </td>
                            <td>
                                {{$sale->store->product->code}}<br>
                                <b>{{$sale->store->product->name}}</b><br>
                                {{$sale->store->product->category->name}}<br>
                                {{$sale->store->product->brand->name}}<br>
                                @if ($sale->store->product->model_no)
                                <b>Model: </b>{{$sale->store->product->model_no}}<br>
                                @endif
                            </td>
                            <td>{{$sale->store->batch_no}} </td>
                            <td>{{$sale->store->mf_date}}</td>
                            <td>{{$sale->store->exp_date}} </td>
                            <td class="text-right">{{$sale->quantity}} {{$sale->unit->name}}</td>
                            <td class="text-right">{{number_format((float)$sale->rate,2,'.', '')}}</td>
                            <td class="text-right">{{$sale->quantity * $sale->rate }}</td>
                            <td class="text-right">
                                @if ($sale->discount)
                                {{$sale->discount}}{{$sale->discount_in == "fixed" ? '' : '%'}}
                                @endif
                            </td>
                            <td class="text-right">{{$sale->vat}}</td>
                            <td class="text-right">{{number_format((float)$sale->total,2,'.', '')}}</td>
                            <td>
                                <a href="{{route('bills.create',$sale->bill_id)}}" class="text-muted">
                                    <i class="btn btn-primary fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="40" class=" text-center text-danger">*Data Not Found !!!</td>
                        </tr>
                        @endforelse

                    </table>
                </div>
            </div>
        </div>
        {{$sales->links()}}
    </div>
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