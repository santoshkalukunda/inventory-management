@extends('layouts.backend')
@section('title')
Purchase List
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
<div class="row mx-2">
    <div class="col-md-2 form-group">
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-plus"></i> New
            Purchase
        </button>
    </div>
    @include('modal.purchase-modal')
    <div class="col-md-1 form-group">
        <button class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
            aria-controls="filter">
            <i class="fa fa-filter"></i> Filter
        </button>
    </div>
    {{-- <div class="col-md-1 form-group">
        <a class="btn btn-primary" href="{{route('purchase.pdf')}}">
    <i class="fa fa-pdf"></i> PDF
    </a>
</div>
<div class="col-md-1 form-group">
    <a class="btn btn-primary" href="{{route('purchase.excel')}}">
        <i class="fa fa-pdf"></i> Excel
    </a>
</div> --}}
<div class="col-md-9 form-group text-right">
    @php
    $total=0;
    $due=0;
    $payment=0;
    $quantity=0;
    foreach($purchases as $purchase)
    {
    $total=$total+$purchase->total;
    $due=$due+$purchase->due;
    $payment=$payment+$purchase->payment;
    $quantity=$quantity+$purchase->quantity;
    }
    @endphp
    <span class="bg-blue-light p-2"><b>Total Product: </b>{{$quantity}}</span>
    <span class="bg-blue-light p-2"><b>Total Amount: </b>{{$total}}/-</span>
    <span class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</span>
    <span class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</span>
</div>

</div>
@include('purchase.filter-input')
<div class="col-md-12 justify-content-center">
    <div class="ibox">
        <div class="ibox-head d-flex">
            <div class="ibox-title">Purchase List</div>
            <div>Total Result: {{$purchases->total()}}</div>
        </div>
        <div class="ibox-body">
            <div class="table-responsive">
                <table class="table-hover table-bordered">
                    <tr class="text-center bg-light">
                        <th>Order_Date</th>
                        <th>Shipping_Date</th>
                        <th>Bill_No.</th>
                        <th>Dealer</th>
                        <th>Product</th>
                        <th>Batch_No.</th>
                        <th>Manufacture_date</th>
                        <th>Expiry_date</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Discount</th>
                        <th>TAX/VAT</th>
                        <th>Total</th>
                        <th>Pyament</th>
                        <th>Due</th>
                        <th>MRP</th>
                        <th colspan="3">Action</th>
                    </tr>
                    @forelse ($purchases as $purchase)
                    <tr style="white-space:nowrap;">
                        <td>{{$purchase->order_date}}</td>
                        <td>{{$purchase->shipping_date}}</td>
                        <td class="text-right">{{$purchase->bill_no}}</td>
                        <td>
                            <a href="{{route('dealers.show',$purchase->dealer)}}"
                                class="font-14"><b>{{$purchase->dealer->name}}</b></a>
                            <span class=""> <br>{{$purchase->dealer->address}}</span>
                            <span class=""> <br>{{$purchase->dealer->pan_vat}}</span>
                        </td>
                        <td>
                            {{$purchase->product->code}}
                            <br>
                            <b>{{$purchase->product->name}}</b>
                            <br>
                            {{$purchase->product->category->name}}
                            <br>
                            {{$purchase->product->brand->name}}
                            <br>
                            {{$purchase->model_no}}
                            <br>
                            {{$purchase->serial_no}}
                        </td>
                        <td>{{$purchase->batch_no}}</td>
                        <td>{{$purchase->mf_date}}</td>
                        <td>{{$purchase->exp_date}}</td>
                        <td class="text-right">{{$purchase->quantity}} {{$purchase->unit->name}}</td>
                        <td class="text-right">{{number_format((float)$purchase->rate,2,'.', '')}}</td>
                        <td class="text-right">{{$purchase->discount}}%</td>
                        <td class="text-right">{{$purchase->vat}}%</td>
                        <td class="text-right">{{number_format((float)$purchase->total,2,'.', '')}}</td>
                        <td class="text-right">{{number_format((float)$purchase->payment,2,'.', '')}}</td>
                        <td class="text-right">{{number_format((float)$purchase->due,2,'.', '')}}</td>
                        <td class="text-right">{{number_format((float)$purchase->mrp,2,'.', '')}}</td>
                        <td>
                            <a href="{{route('purchase.show',$purchase)}}" class="text-muted"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>
                            <a href="{{route('purchase.edit',$purchase)}}" class="text-muted"><i
                                    class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <form action="{{route('purchase.destroy',$purchase)}}"
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
    {{$purchases->links()}}
</div>
@endsection