@extends('layouts.backend')
@section('title')
Purchase Bill List
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
            Bill
        </button>
    </div>
    @include('modal.purchase-modal')
    <div class="col-md-1 form-group">
        <button class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
            aria-controls="filter">
            <i class="fa fa-filter"></i> Filter
        </button>
    </div>
    <div class="col-md-9 form-group text-right">
        <span class="bg-blue-light p-2"><b>Net Total : </b>{{$net_total}}/-</span>
        <span class="bg-blue-light p-2"><b>Payment :</b> {{$payment}}/-</span>
        <span class="bg-blue-light p-2"> <b>Due :</b> {{$due}}/-</span>
    </div>
    <div class="col-md-12 mb-2">
        <div class="collapse" id="filter">
            <div class="card card-body">
                <form action="{{route('purchase-bills.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="dealer_id">Dealer Name</label>br
                            <select class="selectpicker form-control @error('dealer_id') is-invalid @enderror"
                                name="dealer_id" id="product" data-live-search="true" data-size="4">
                                <option value="" selected>Select Dealer</option>
                                @foreach ($dealers as $dealer)
                                <option value="{{$dealer->id}}" data-content="<b>{{$dealer->name}}</b>
                                    <br>{{$dealer->address}}
                                    <br>{{$dealer->phone}}
                                    <br>{{$dealer->pan_vat}}
                                    "></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="user_id">User Name</label>
                            <select class="selectpicker form-control @error('user_id') is-invalid @enderror"
                                name="user_id" id="product" data-live-search="true" data-size="4">
                                <option value="" selected>Select User</option>
                                @foreach ($users as $user)
                                <option value="{{$user->id}}"data-content="<b>{{$user->name}}</b>"></option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="order_date_from">Order Date From</label>
                            <input type="date" class="form-control" name="order_date_from" id="order_date_from"
                                placeholder="Order Date From" autofocus>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="order_date_to">Order Date To</label>
                            <input type="date" class="form-control" name="order_date_to" id="order_date_to"
                                placeholder="Order Date" autofocus>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="shipping_date_from">Shipping Date From</label>
                            <input type="date" class="form-control @error('shipping_date_from') is-invalid @enderror"
                                name="shipping_date_from" id="shipping_date_from" placeholder="Shipping Date">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="shpping_date">Shipping Date To</label>
                            <input type="date" class="form-control @error('shipping_date_to') is-invalid @enderror"
                                name="shipping_date_to" id="shipping_date_to" placeholder="Shipping Date">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="status">Status Name</label>
                            <select class="selectpicker form-control @error('status') is-invalid @enderror"
                                name="status" id="status" data-live-search="true" data-size="4">
                                <option value="" selected>Select Satus</option>
                                <option value="incomplete">Incomplete</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="bill_no">Bill No.</label>
                            <input type="number" min="0" class="form-control @error('bill_no') is-invalid @enderror"
                                name="bill_no" id="bill_no" placeholder="Bill No." autofocus>
    
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
                            <label for="total_min">Total Min.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_min') is-invalid @enderror" name="total_min"
                                id="total_min" placeholder="Net-Total Min.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="total_max">Total Max.</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total_max') is-invalid @enderror" name="total_max"
                                id="total_max" placeholder="Net-Total Max.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="net_total_min">Net Total Min.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('net_total_min') is-invalid @enderror"
                                name="net_total_min" id="net_total_min" placeholder="Net Total Min">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="net_total_max">Net Total Max</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('net_total_max') is-invalid @enderror"
                                name="net_total_max" id="net_total_max" placeholder="Net Total Max">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="payment_min">Payment Min.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('payment_min') is-invalid @enderror"
                                name="payment_min" id="payment_min" placeholder="Payment Min. Rs.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="payment_max">Payment Max.</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('payment_max') is-invalid @enderror"
                                name="payment_max" id="payment_max" placeholder="Payment Max. Rs.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="due_min">Due Min.</label>
                            <input type="number" step="any"
                                class="form-control text-right @error('due_min') is-invalid @enderror" name="due_min"
                                id="due_min" placeholder="Due Min. Rs.">
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="due_max">Due Max.</label>
                            <input type="number" step="any"
                                class="form-control text-right @error('due_max') is-invalid @enderror" name="due_max"
                                id="due_max" placeholder="Due Max. Rs.">
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
</div>
<div class="col-md-12 justify-content-center">
   @include('purchase-bill.list')
</div>
@endsection