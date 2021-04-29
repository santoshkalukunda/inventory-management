@extends('layouts.backend')
@section('title')
Dealer List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 text-center my-4">
       <h3>{{$dealer->name}}</h3>
       <div>{{$dealer->address}}</div>
       <div>{{$dealer->phone}}, {{$dealer->email}}</div>
       <div><b>PAN/VAT :</b> {{$dealer->pan_vat}}</div>
       <div><b>Reg. No. :</b> {{$dealer->reg_no}}</div>
       <div class="d-flex  mt-lg-0 mt-3 mx-3 justify-content-center">
           <div class="bg-blue-light p-2"><b>Net Total: </b>{{$net_total}}/-</div>
           <div class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</div>
           <div class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</div>
       </div>
    </div>
</div>
<div class="col-md-12 justify-content-center">
    @include('purchase-bill.list')
</div>

@endsection