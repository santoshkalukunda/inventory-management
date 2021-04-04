@extends('layouts.backend')
@section('title')
Purchase Bill List
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
<div class="row mx-2">
    <div class="col-md-2 form-group">
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i> New
            Bill
        </button>
    </div>
    @include('modal.purchase-modal')
    <div class="col-md-1 form-group">
        <p>
            <a class="btn btn-primary" onclick="btn1()" data-toggle="collapse" href="#filter" role="button"
                aria-expanded="false" aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </p>
    </div>
    <div class="col-md-1 form-group">
        <p>
            <a class="btn btn-primary" onclick="btn2()" data-toggle="collapse" href="#report" role="button"
                aria-expanded="false" aria-controls="report">
                <i class="fa fa-file-pdf"></i> Reports
            </a>
        </p>
    </div>
    <div class="col-md-8 form-group text-right">
        <span class="bg-blue-light p-2"><b>Net Total : </b>{{$net_total}}/-</span>
        <span class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</span>
        <span class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</span>
    </div>
    <div class="col-md-12 mb-2">
        {{-- filter-search --}}
        <div class="mb-2" id="demo">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('purchase-bills.search')}}" method="get">
                        @include('purchase-bill.filter-input')
                        <div class="row">
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mb-2" id="demo1">
            {{-- report-generate --}}
            <div class="collapse" id="report">
                <div class="card card-body">
                    <form action="{{route('purchase-bills.report')}}" method="get">
                        @include('purchase-bill.filter-input')
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
</div>
<div class="col-md-12 justify-content-center">
   @include('purchase-bill.list')
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