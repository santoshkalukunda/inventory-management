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
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Product Sale</div>
                </div>
                <div class="ibox-body">
                    <form action="" method="post">
                        @csrf
                        {{-- @include('purchase.input') --}}
                    </form>
                    {{-- <livewire:purchase-form :dealer="$dealer" /> --}}
                </div>
            </div>
        </div>
    </div>

@endsection