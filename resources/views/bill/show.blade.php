@extends('layouts.backend')
@section('title')
Sale Deu Payment
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
    <div class="col-md-12 text-center mb-2">
        <h3>{{$bill->customer->name}}</h3>
        <div>{{$bill->customer->address}}</div>
        <div>{{$bill->customer->phone}}, {{$bill->customer->email}}</div>
        <div><b>PAN/VAT :</b>{{$bill->customer->pan_vat}}</div>

    </div>

    <div class="col-md-12 mb-2">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Deu Pay [Invoice No. {{$bill->invoice_no}}]</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('sale-dues.store',compact('bill'))}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="date" class="required">Billing Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{old('date',date('Y-m-d'))}}" name="date" id="date" placeholder="Order Date">
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="due_amount">Deu Amount</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('due_amount') is-invalid @enderror"
                                name="due_amount" value="{{round($bill->due, 2)}}" id="due_amount" placeholder="Due Amount"
                                readonly>
                            @error('due_amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="payment" class="required">Pay Amount</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('payment') is-invalid @enderror" name="payment"
                                value="{{old('payment')}}" id="payment" placeholder="Rs.0" onkeyup="fun()">
                            @error('payment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-2 form-group">
                            <label for="due">Due</label>
                            <input type="number" step="any"
                                class="form-control text-right @error('due') is-invalid @enderror" name="due"
                                value="{{old('due')}}" id="due" placeholder="0" readonly>
                            @error('due')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label for="" class="mb-4"></label>
                            <button type="submit" class="btn btn-success form-control btn-rounded">Pay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 justify-content-center">
       @include('sale-due.list')
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