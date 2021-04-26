@extends('layouts.backend')
@section('title')
Bill Create
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
    @if ($bill->status=="incomplete")
    <div class="col-md-9">
        @include('sale.create')
    </div>
    @endif
    <div class="{{$bill->status=="incomplete" ? "col-md-3" : "col-md-12"}} ">
        <div class="mb-3">
            <div class="  text-center">
                <b>{{$bill->customer->name}}</b>
                <div> {{$bill->customer->address}}</div>
                <div>{{$bill->customer->phone}}, {{$bill->customer->email}}</div>
                @if ($bill->customer->pan_vat)
                <div>{{$bill->customer->pan_vat}}</div>
                @endif
            </div>
        </div>
        <div class="ibox">
            <div class="text-center font-bold">Bill Status</div>
            <div class="ibox-body  text-center">
                @if ($bill->status=="incomplete")
                <div class="bg-primary text-capitalize text-white">{{$bill->status}}</div>
                @elseif($bill->status=="complete")
                <span class="bg-success text-capitalize px-2 py-1 text-white">{{$bill->status}}</span>
                <div class="my-3 row text-center">
                    <div class="badge-primary p-1 m-1 col-md"> <b>Bill Date: </b> <br> {{$bill->date}} </div>
                    <div class="badge-primary  p-1 m-1 col-md"> <b>Invoice No.: </b> <br> {{$bill->invoice_no}} </div>
                    <div class="badge-primary p-1 m-1 col-md"> <b>Total: </b><br> {{$bill->total}} </div>
                    <div class="badge-primary  p-1 m-1 col-md"> <b>Discount: </b> <br> {{$bill->discount}} {{$bill->discount_in}} </div>
                    <div class="badge-primary  p-1 m-1 col-md"> <b>VAT: </b><br> {{$bill->vat}} </div>
                    <div class="badge-primary p-1 m-1 col-md"> <b>Net-total : </b><br> {{$bill->net_total}}/- </div>
                    <div class="badge-primary  p-1 m-1 col-md"><b>Pay Amount :</b><br> {{$bill->payment}}/- </div>
                    <div class="badge-primary p-1 m-1 col-md"><b>Due :</b><br> {{$bill->due}}</div>
                </div>
                <div class="col-md-2">
                    <a href="{{route('bills.pdf',$bill)}}" target="_blank"
                        class="btn btn-success form-control btn-rounded"><i class="fa fa-print"></i> Invoice Print</a>
                </div>
                @if ($bill->remarks)
                <label for="" class="font-bold">Remarks</label>
                <div class="col-md-12 text-left"
                    style="height:80px; border:1px solid #ccc;font:16px/26px Georgia, Garamond, Serif;overflow:auto;">
                    {!! $bill->remarks !!}
                </div>
                @endif
                @else
                <div class="bg-danger text-capitalize text-white">{{$bill->status}}</div>
                @endif

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Product List</div>
            </div>
            <div class="ibox-body table-responsive">
                <table class="table">
                    <tr>
                        <th class="text-right">S.N.</th>
                        <th>Produtct</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Tax/VAT</th>
                        <th class="text-right">Net Total</th>
                        <th colspan="2">Action</th>
                    </tr>
                    @php
                    $i=1;
                    @endphp
                    @forelse ($sales as $sale)
                    <tr>
                        <td class="text-right">{{$i++}}</td>
                        <td>{{$sale->store->product->name}}</td>
                        <td class="text-right">{{$sale->quantity}} {{$sale->unit->name}}</td>
                        <td class="text-right">{{$sale->rate}}</td>
                        <td class="text-right">{{$sale->total_cost}}</td>
                        <td class="text-right">
                            @if ($sale->discount)
                            {{$sale->discount}}{{$sale->discount_in == "fixed" ? '' : '%'}}
                            @endif
                        </td>
                        <td class="text-right">{{$sale->vat}}</td>
                        <td class="text-right">{{round($sale->total, 2)}}</td>
                        @if ($bill->status == "incomplete")
                        <td>
                            <form action="{{route('sales.destroy',$sale)}}"
                                onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                        class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td class=" text-danger text-center" colspan="48">*No product Added</td>
                    </tr>
                    @endforelse

                </table>
            </div>
        </div>
    </div>
    @if ($bill->status == "incomplete")
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Product Sale</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('bills.update',$bill)}}" method="post">
                    @csrf
                    @method('put')
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
                            <label for="total">Total</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total') is-invalid @enderror" name="total"
                                value="{{round($salestotal, 2)}}" id="ptotal" placeholder="Total" onkeyup="funn()">
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
                                <option value="percent" selected>Percent</option>
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
                                name="net_total" value="{{round($salestotal, 2)}}" id="net_total"
                                placeholder="Net-Total" onkeyup="funn()">
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
                        <div class="form-group col-md-5">
                            <label for="remarks">Remarks</label>
                            <textarea type="text" name="remarks"
                                class="form-control  @error('remarks') is-invalid @enderror" rows="2"
                                placeholder="write somthing...">{{old('remarks')}}</textarea>
                            @error('remarks')
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
            </div>
        </div>
    </div>
    @endif

</div>
<script>
    function funn(){
    var total = document.getElementById("ptotal").value;
    var discount = document.getElementById("pdiscount").value;
    var discount_in = document.getElementById("pdiscount_in").value;
    var vat = document.getElementById("pvat").value;
    var payment = document.getElementById("payment").value;
    var net_total = document.getElementById("net_total").value;
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