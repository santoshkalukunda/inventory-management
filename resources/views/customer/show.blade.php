@extends('layouts.backend')
@section('title')
Bill List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 text-center my-2">
        <h3>{{$customer->name}}</h3>
        <div>{{$customer->address}}</div>
        <div>{{$customer->phone}}, {{$customer->email}}</div>
        <div><b>PAN/VAT :</b> {{$customer->pan_vat}}</div>
        <div class="d-flex  mt-lg-0 mt-3 mx-3 justify-content-center">
            <div class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</div>
            <div class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</div>
            <div class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</div>
        </div>
    </div>
    <div class="col-md-12 justify-content-center">
        @include('bill.list')
    </div>
</div>
@endsection