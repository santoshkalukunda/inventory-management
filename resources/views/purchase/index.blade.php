@extends('layouts.backend')
@section('title')
Purchase List
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
<div class="row px-2">
    <div class="col-md-2 px-1 mb-2">
        <button class="btn btn-primary form-control" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i> New
            Purchase
        </button>
    </div>
    @include('modal.purchase-modal')
    <div class="col-md-2 px-1">
        <p>
            <a class="btn btn-primary form-control" onclick="btn1()" data-toggle="collapse" href="#filter" role="button"
                aria-expanded="false" aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </p>
    </div>
    <div class="col-md-2 px-1">
            <a class="btn btn-primary form-control" onclick="btn2()" data-toggle="collapse" href="#report" role="button"
                aria-expanded="false" aria-controls="report">
                <i class="fa fa-file-pdf"></i> Reports
            </a>
    </div>
    <div class=" col-md-6 d-flex  mt-lg-0 mt-3 justify-content-end my-2">
        <div class="bg-blue-light p-2"><b>Total Product: </b>{{$quantity}}</div>
        <div class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</div>
    </div>

</div>
<div class="mb-2">
    {{-- filter-search --}}
    <div class="mb-2" id="demo">
        <div class="collapse" id="filter">
            <div class="card card-body">
                <form action="{{route('purchase.search')}}" method="get">
                    @include('purchase.filter-input')
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
                <form action="{{route('purchase.report')}}" method="get">
                    @include('purchase.filter-input')
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
<div class="">
    @include('purchase.list')
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