@extends('layouts.backend')
@section('title')
Sales List
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
<div class="row mx-1">
    <div class="col-md-2">
        <button class="btn btn-primary mb-2 form-control" data-toggle="modal" data-target="#new-bill"> <i
                class="fa fa-plus"></i> New
            Sale
        </button>
        @include('modal.bill-create')
    </div>
    <div class="col-md-1 form-group">
        <button class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
            aria-controls="filter">
            <i class="fa fa-filter"></i> Filter
        </button>
    </div>

    
    <div class="col-md-9 form-group text-right">
        @php
        $total=0;
        $due=0;
        $payment=0;
        $quantity=0;
        foreach($sales as $sale)
        {
        $total=$total+$sale->total;
        $quantity=$quantity+$sale->quantity;
        }
        @endphp
        <span class="bg-blue-light p-2"><b>Product Quantity: </b>{{$quantity}}</span>
        <span class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</span>
    </div>
</div>
<div class="col-md-12 justify-content-center">
    <div class="ibox">
        <div class="ibox-head d-flex">
            <div class="ibox-title">Sales List</div>
            <div>Total Result: {{$sales->total()}}</div>
        </div>
        <div class="ibox-body">
            <div class="table-responsive">
                <table class="table-hover table">
                    <tr class="text-center bg-light">
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Rate</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">TAX/VAT</th>
                        <th class="text-right">Net-Total</th>
                        <th colspan="3">Action</th>
                    </tr>
                    @forelse ($sales as $sale)
                    <tr style="white-space:nowrap;">
                        <td>{{$sale->date}}</td>
                        <td>
                            <b>{{$sale->customer->name}}</b></a>
                            <span class=""> <br>{{$sale->customer->address}}</span>
                            <span class=""> <br>{{$sale->customer->phone}}</span>
                            <span class=""> <br>{{$sale->customer->pan_vat}}</span>
                        </td>
                        <td>
                            {{$sale->store->product->code}}
                            <br>
                            <b>{{$sale->store->product->name}}</b>
                            <br>
                            {{$sale->store->product->category->name}}
                            <br>
                            {{$sale->store->product->brand->name}}
                            <br>
                            {{$sale->store->product->model_no}}
                        </td>
                        <td class="text-right">{{$sale->quantity}} {{$sale->unit->name}}</td>
                        <td class="text-right">{{number_format((float)$sale->rate,2,'.', '')}}</td>
                        <td class="text-right">{{$sale->quantity * $sale->rate }}</td>
                        <td class="text-right">{{$sale->discount}}%</td>
                        <td class="text-right">{{$sale->vat}}%</td>
                        <td class="text-right">{{number_format((float)$sale->total,2,'.', '')}}</td>
                        <td>
                            @php
                            $customer=$sale->customer_id;
                            $bill=$sale->bill_id;
                            @endphp
                            <a href="{{route('bills.create', compact('customer','bill'))}}" class="text-muted"><i
                                    class="fa fa-edit"></i></a>
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
                        <td colspan="40" class=" text-center text-danger">*Data Not Found !!!</td>
                    </tr>
                    @endforelse

                </table>
            </div>
        </div>
    </div>
    {{$sales->links()}}
</div>
@endsection