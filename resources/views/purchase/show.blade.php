@extends('layouts.backend')
@section('title')
Purchase Deu Payment
@endsection
@section('content')
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
<div class="row">
    <div class="col-md-12 text-center my-3">
        <h3>{{$dealer->name}}</h3>
        <div>{{$dealer->address}}</div>
        <div>{{$dealer->phone}}, {{$dealer->email}}</div>
        <div><b>PAN/VAT :</b> {{$dealer->pan_vat}}</div>
       <div><b>Reg. No. :</b> {{$dealer->reg_no}}</div>
    </div>
    <div class="col-md-12 justify-content-center">
        @include('purchase.list')
    </div>
</div>
@endsection
<script>
    function fun(){
    var payment = document.getElementById("payment").value;
    var due_amount = document.getElementById("due_amount").value;
    var due =  due_amount - payment;
    document.getElementById("due").value = due.toFixed(2);
      }
</script>