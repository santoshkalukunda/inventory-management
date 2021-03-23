@extends('layouts.backend')
@section('title')
Dealer List
@endsection
@section('content')
<div class="row mx-2">
    <div class="col-md-12 text-center my-4">
       <h3>{{$dealer->name}}</h3>
       <div>{{$dealer->address}}</div>
       <div>{{$dealer->phone}}, {{$dealer->email}}</div>
       <div><b>PAN/VAT :</b> {{$dealer->pan_vat}}</div>
       <div><b>Reg. No. :</b> {{$dealer->reg_no}}</div>
    </div>
    <div class="col-md-12 form-group text-center">
        <span class="bg-blue-light p-2"><b>Total Product: </b>{{$quantity}}</span>
        <span class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</span>
        <span class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</span>
        <span class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</span>
    </div>

</div>
<div class="col-md-12 justify-content-center">
    @include('purchase.list')
</div>

@endsection