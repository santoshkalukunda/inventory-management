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
    <div class="col-md-12 mb-2">
        <div class="collapse" id="filter">
            <div class="card card-body">
                <form action="{{route('sales.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="customer_id">Customer Name</label>
                            <select class="selectpicker form-control @error('customer_id') is-invalid @enderror"
                                name="customer_id" id="product" data-live-search="true" data-size="4">
                                <option value="" selected>Select Customer</option>
                                @foreach ($customers as $customer)
                                <option value="{{$customer->id}}" data-content="<b>{{$customer->name}}</b>
                                    <br>{{$customer->address}}
                                    <br>{{$customer->phone}}
                                    <br>{{$customer->pan_vat}}
                                    "></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="store_id">Product</label>
                            <select class="selectpicker form-control @error('store_id') is-invalid @enderror"
                                name="store_id" id="store_id" data-live-search="true" data-size="4">
                                <option value="" selected>Select Product</option>
                                @foreach ($stores as $store)
                                <option value="{{$store->id}}" data-content="<b>{{$store->product->name}}</b>
                                    <br>{{$store->product->code}}
                                    <br>{{$store->product->brand->name}}
                                    <br>{{$store->product->category->name}}
                                    <br>{{$store->product->model_no}}
                                    "></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="bill_date_from">Bill Date From</label>
                            <input type="date" class="form-control" name="bill_date_from" id="bill_date_from"
                                placeholder="Bill Date From" autofocus>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="bill_date_to">Bill Date To</label>
                            <input type="date" class="form-control" name="bill_date_to" id="bill_date_to"
                                placeholder="Bill Date To" autofocus>
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="invoice_no_min">Invoice No. Min.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('invoice_no_min') is-invalid @enderror"
                                name="invoice_no_min" id="invoice_no_min" placeholder="Invoice No. Min">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="invoice_no_max">Invoice No Max</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('invoice_no_max') is-invalid @enderror"
                                name="invoice_no_max" id="invoice_no_max" placeholder="Invoice No. Max">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="quantity_min">Quantity Min</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('quantity_min') is-invalid @enderror"
                                name="quantity_min" id="quantity_min" placeholder="Quantity Min">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="quantity_max">Quantity Max</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('quantity_max') is-invalid @enderror"
                                name="quantity_max" id="quantity_max" placeholder="Quantity Max">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="unit_id">Unit</label>
                            <select class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id"
                                id="unit_id" data-live-search="true" data-size="5">
                                <option value="" selected>Select Unit</option>
                                @foreach ($units as $unit)
                                <option value="{{$unit->id}}">
                                    {{$unit->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="rate_min">Rate Min.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('rate_min') is-invalid @enderror" name="rate_min"
                                id="rate_min" placeholder="Rate Min. Rs.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="rate_max">Rate Max.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('rate_max') is-invalid @enderror" name="rate_max"
                                id="rate_max" placeholder="Rate Max. Rs.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total_cost_min">Total Min.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_cost_min') is-invalid @enderror" name="total_cost_min"
                                id="total_cost_min" placeholder="total Min.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total_cost_max">Net total_cost Max.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_cost_max') is-invalid @enderror" name="total_cost_max"
                                id="total_cost_max" placeholder="total Max.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="discount_min">Discount Min. in %</label>
                            <input type="number" Min="0" step="any"
                                class="form-control text-right @error('discount_min') is-invalid @enderror"
                                name="discount_min" id="discount_min" placeholder="Discount Min.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="discount_max">Discount Max. in%</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('discount_max') is-invalid @enderror"
                                name="discount_max" id="discount_max" placeholder="Discount Max in %">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="vat_min">TAX/VAT Min. in%</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('vat_min') is-invalid @enderror" name="vat_min"
                                id="vat_min" placeholder="TAX/VAT Min.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="vat_max">TAX/VAT Max. in %</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('vat_max') is-invalid @enderror" name="vat_max"
                                id="vat_max" placeholder="TAX/VAT Max.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total_min">Net Total Min.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_min') is-invalid @enderror" name="total_min"
                                id="total_min" placeholder="Net-Total Min.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total_max">Net Total Max.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_max') is-invalid @enderror" name="total_max"
                                id="total_max" placeholder="Net-Total Max.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <input type="submit" class="form-control btn- btn-primary" value="Search">
                        </div>
                    </div>
                </form>
            </div>
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
                            <th>Invoice No.</th>
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
                            <td>{{$sale->invoice_no}}</td>
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
                            {{-- <td>
                                <form action="{{route('sales.destroy',$sale)}}"
                                    onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                            class="fa fa-trash-alt"></i></button>
                                </form>
                            </td> --}}
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
</div>
@endsection