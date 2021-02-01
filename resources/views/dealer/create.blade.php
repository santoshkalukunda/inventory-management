@extends('layouts.backend')
@section('title')
    Dealer Registration
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Dealer Registration Form</div>
                </div>
                <div class="ibox-body">
                    <form action="{{route('dealers.store')}}" method="post">
                        @csrf
                        @include('dealer.input')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
