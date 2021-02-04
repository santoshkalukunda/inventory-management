@extends('layouts.backend')
@section('title')
Dealer Update
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Dealer Update Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('dealers.update',$dealer)}}" method="post">
                    @method('put')
                    @csrf
                    @include('dealer.input')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection