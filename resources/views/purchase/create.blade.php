@extends('layouts.backend')
@section('title')
Dealer Registration
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
    <div class="row justify-content-center">
        <div class="col-md-12 text-center mb-3">
            <div >
                <div >
                    <h3 class=" text-capitalize">{{$purchaseBill->dealer->name}}</h3>
                    <div> {{$purchaseBill->dealer->address}}</div>
                    <div>{{$purchaseBill->dealer->phone}}, {{$purchaseBill->dealer->email}}</div>
                    <div><b>PAN/VAT :</b> {{$purchaseBill->dealer->pan_vat}}</div>
                    <div><b>Reg. no :</b> {{$purchaseBill->dealer->reg_no}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Buy</div>
                </div>
                <div class="ibox-body">
                    <form action="{{route('purchase.store',$purchaseBill->dealer)}}" method="post">
                        @csrf
                        @include('purchase.input')
                    </form>
                </div>
            </div>
        </div>
        
    </div>

@endsection