@extends('layouts.backend')
@section('title')
Purchase Bill Create
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
    @if ($purchaseBill->status == "incomplete")
    <div class="col-md-9">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Product Buy</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('purchase.store', $purchaseBill)}}" method="post">
                    @csrf
                    @include('purchase.input')
                </form>
            </div>
        </div>
    </div>
    @endif
    <div class="{{$purchaseBill->status == "incomplete" ? "col-md-3" : "col-md-12"}} text-center">
        <div class="mb-3 bg-primary text-white p-3">
            <div class="text-center">
                <b>{{$purchaseBill->dealer->name}}</b>
                <div> {{$purchaseBill->dealer->address}}</div>
                <div>{{$purchaseBill->dealer->phone}}, {{$purchaseBill->dealer->email}}</div>
                @if ($purchaseBill->dealer->pan_vat)
                <div>{{$purchaseBill->dealer->pan_vat}}</div>
                @endif
            </div>
        </div>
        <div class="ibox">
            <div class="text-center font-bold">Bill Status</div>
            <div class="ibox-body  text-center">
                @if ($purchaseBill->status=="incomplete")
                <div class="bg-primary text-capitalize px-2 py-1 text-white">{{$purchaseBill->status}}</div>
                @elseif($purchaseBill->status=="complete")
                <div class="row  text-center">
                    <div class="col-md-4">
                        <div class="btn btn-primary">Order Date : {{$purchaseBill->order_date}}</div>
                        <div class="btn btn-primary m-2"><span>PShipping Date :</span> {{$purchaseBill->shipping_date}}
                        </div>
                        <div class="btn btn-primary m-2"><span>Bill No. :</span> {{$purchaseBill->bill_no}}</div>
                    </div>
                    <div class="col-md-4">
                        <div><span
                                class="bg-success text-capitalize px-2 py-1 text-white">{{$purchaseBill->status}}</span>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="btn btn-primary">Net-Total : {{$purchaseBill->net_total}}</div>
                        <div class="btn btn-primary m-2"><span>Payment :</span>{{$purchaseBill->payment}}</div>
                        <div class="btn btn-primary m-2"><span>Due :</span>{{$purchaseBill->due}}</div>
                    </div>
                </div>
                @else
                <div class="bg-danger text-capitalize px-2 py-1 text-white">{{$purchaseBill->status}}</div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @include('purchase.list')
    </div>
    @if ($purchaseBill->status == "incomplete")
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Purchase Bill Pay</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('purchase-bills.update',$purchaseBill)}}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="order_date" class="required">Order Date</label>
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror"
                                value="{{old('order_date')}}" name="order_date" id="order_date"
                                placeholder="Order Date">
                            @error('order_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="shpping_date" class="required">Shipping Date</label>
                            <input type="date" class="form-control @error('shipping_date') is-invalid @enderror"
                                value="{{old('shipping_date')}}" name="shipping_date" id="shipping_date"
                                placeholder="Shipping Date">
                            @error('shipping_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="bill_no" class="required">Bill No.</label>
                            <input type="number" min="0" class="form-control @error('bill_no') is-invalid @enderror"
                                value="{{old('bill_no')}}" name="bill_no" id="bill_no" placeholder="Bill No.">
                            @error('bill_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total">Total</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total') is-invalid @enderror" name="total"
                                value="{{old('total',$total)}}" id="ptotal" placeholder="Total" onkeyup="funn()">
                            @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="pdiscount_in" class="required">Discoutn in </label>
                            <select class="form-control @error('pdiscount_in') is-invalid @enderror" name="discount_in"
                                id="pdiscount_in" onchange="funn()">
                                <option value="percent" selected>Percent %</option>
                                <option value="fixed">Fixed</option>
                            </select>
                            @error('discount_in')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="discount">Discount</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('discount') is-invalid @enderror" name="discount"
                                value="{{old('discount')}}" id="pdiscount" placeholder="Discount" onkeyup="funn()">
                            @error('discount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="vat">VAT in %</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('vat') is-invalid @enderror" name="vat"
                                value="{{old('vat')}}" id="pvat" placeholder="VAT in %" onkeyup="funn()">
                            @error('vat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="net_total">Net-Total</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('net_total') is-invalid @enderror"
                                name="net_total" value="{{old('net_total', $total)}}" id="net_total"
                                placeholder="Net-Total">
                            @error('net_total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="payment" class="required">Payment Amount</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('payment') is-invalid @enderror" name="payment"
                                value="{{old('payment')}}" id="payment" placeholder="Payment Rs." onkeyup="funn()">
                            @error('payment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-md-2 form-group">
                            <label for="due">Due Amount</label>
                            <input type="number" step="any"
                                class="form-control text-right @error('due') is-invalid @enderror" name="due"
                                value="{{old('due')}}" id="due" placeholder="Due Amount">
                            @error('due')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="" class="mb-4"></label>
                            <button type="submit" class="btn btn-success form-control btn-rounded">Pay</button>
                        </div>
                    </div>
                </form>
             
                    <div class="d-flex justify-content-end">
                        <form action="{{route('purchase-bills.destroy',$purchaseBill)}}"
                            onsubmit="return confirm('Are you sure to delete bill?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-sm btn-danger px-3  form-control btn-rounded"
                                data-toggle="tooltip" data-placement="top" title="Delete Bill">Delete</button>
                        </form>
                    </div>
                
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    function funn(){
    var total = document.getElementById("ptotal").value;
    var discount_in = document.getElementById("pdiscount_in").value;
    var discount = document.getElementById("pdiscount").value;
    var vat = document.getElementById("pvat").value;
    var payment = document.getElementById("payment").value;
    if (discount_in != "fixed") {     
    total = total - ((total * (discount)/100));
    } else {
        total = total - discount;
    }
     var total = total + ((total * (vat)/100));
    document.getElementById("net_total").value = total.toFixed(2);
    document.getElementById("due").value = (total - payment).toFixed(2);
    }
</script>

@endsection