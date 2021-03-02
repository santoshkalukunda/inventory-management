@extends('layouts.backend')
@section('title')
Bill List
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 text-center">
        <h3>{{$customer->name}}</h3>
        <div>{{$customer->address}}</div>
        <div>{{$customer->phone}}, {{$customer->email}}</div>
        <div><b>PAN/VAT :</b> {{$customer->pan_vat}}</div>
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
                            <input type="text" class=" form-control" name="name" placeholder="Name">
                        </div>
                        <div class="col-md-3 form-group">
                            <input type="text" class=" form-control" name="address" placeholder="Address">
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