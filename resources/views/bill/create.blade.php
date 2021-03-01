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
    @if ($bill->status=="incomplete")
    <div class="col-md-9">
        @include('sale.create')
    </div>
    @endif
    <div class="{{$bill->status=="incomplete" ? "col-md-3" : "col-md-12"}} ">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Customer Details</div>
            </div>
            <div class="ibox-body  text-center">
                <b>{{$customer->name}}</b>
                <div> {{$customer->address}}</div>
                <div>{{$customer->phone}}, {{$customer->email}}</div>
                @if ($customer->pan_vat)
                <div>{{$customer->pan_vat}}</div>
                @endif
            </div>
        </div>
        <div class="ibox">
            <div class="text-center font-bold">Bill Status</div>
            <div class="ibox-body  text-center">
                @if ($bill->status=="incomplete")
                <div class="btn btn-primary text-capitalize">{{$bill->status}}</div>
                @elseif($bill->status=="complete")
                <div class="btn btn-success text-capitalize">{{$bill->status}}</div>
                @else
                <div class="btn btn-danger text-capitalize">{{$bill->status}}</div>
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
                        <td class="text-right">{{$sale->discount ?? "0"}}%</td>
                        <td class="text-right">{{$sale->vat ?? "0"}}%</td>
                        <td class="text-right">{{round($sale->total, 2)}}</td>
                        <td>
                            <a href="{{route('sales.edit',$sale)}}" class="text-muted"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <form action="{{route('sales.destroy',$sale)}}"
                                onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                        class="fa fa-trash-alt"></i></button>
                            </form>
                        </td>
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
    @if ($bill->status=="incomplete")
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
                                value="{{old('date')}}" name="date" id="date" placeholder="Order Date">
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="net_total">Net-Total</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('net_total') is-invalid @enderror"
                                name="net_total" value="{{round($net_tatal, 2)}}" id="net_total" placeholder="Net-Total"
                                readonly>
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
                                value="{{old('payment')}}" id="payment" placeholder="Payment Rs." onkeyup="fun()">
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
                                value="{{old('due')}}" id="due" placeholder="Due Amount" readonly>
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
    @endif

</div>
<script>
    function fun(){
    var payment = document.getElementById("payment").value;
    var net_total = document.getElementById("net_total").value;
    var due= net_total - payment;
    document.getElementById("due").value = due.toFixed(2);
      }
</script>

@endsection