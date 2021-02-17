@extends('layouts.backend')
@section('title')
Customer Update
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Customer Update Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('customers.update',$customer)}}" method="post">
                    @method('put')
                    @csrf
                    @include('customer.input')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection