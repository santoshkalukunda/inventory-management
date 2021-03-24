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
<div class="row mx-2">
    <div class="col-md-2 form-group">
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i> New
            Purchase
        </button>
    </div>
    @include('modal.purchase-modal')
    <div class="col-md-1 form-group">
        <button class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
            aria-controls="filter">
            <i class="fa fa-filter"></i> Filter
        </button>
    </div>
    <div class="col-md-9 form-group text-right">
        <span class="bg-blue-light p-2"><b>Total Product: </b>{{$quantity}}</span>
        <span class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</span>
        <span class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</span>
        <span class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</span>
    </div>

</div>
@include('purchase.filter-input')
<div class="col-md-12 justify-content-center">
    @include('purchase.list')
</div>
@endsection