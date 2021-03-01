@extends('layouts.backend')
@section('title')
Customer List
@endsection
@section('content')
<div class="row">
    <div class="col-md-2">
        <button class="btn btn-primary mb-2 form-control" data-toggle="modal" data-target="#new-bill"> <i
                class="fa fa-plus"></i> New
            Bill
        </button>
        @include('modal.bill-create')
    </div>
    <div class="col-md-2">
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </p>
    </div>
    <div class="col-md-12 mb-2">
        <div class="collapse" id="filter">
            <div class="card card-body">
                <form action="{{route('customers.search')}}" method="get">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="customer_id">Customer Name</label>br
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
                           
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" class=" form-control" name="phone" placeholder="Phone no.">
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" class=" form-control" name="email" placeholder="Email">
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" class=" form-control" name="pan_vat" placeholder="Pan/Vat No.">
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="number" min="0" class=" form-control" name="age_min" placeholder="Age Min.">
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="number" min="0" class=" form-control" name="age_max" placeholder="Age Max.">
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
        @include('bill.list')
    </div>
</div>

@endsection