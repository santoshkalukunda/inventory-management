@extends('layouts.backend')
@section('title')
Dealer Registration
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-body">
                    <h3 class=" text-capitalize">{{$dealer->name}}</h3>
                    <div><b>Address:</b> {{$dealer->address}}</div>
                    <div><b>Phone:</b> {{$dealer->phone}}</div>
                    <div><b>PAN/VAT :</b> {{$dealer->pan_vat}}</div>
                    <div><b>Reg. no :</b> {{$dealer->reg_no}}</div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Buy</div>
                </div>
                <div class="ibox-body">
                    <form action="{{route('purchase.store',$dealer)}}" method="post">
                        @csrf
                        @include('purchase.input')
                    </form>
                    {{-- <livewire:purchase-form :dealer="$dealer" /> --}}
                </div>
            </div>
        </div>
    </div>

@endsection