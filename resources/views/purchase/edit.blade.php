@extends('layouts.backend')
@section('title')
Purchase Update
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Purchase Update Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('purchase.update',$purchase)}}" method="post">
                    @method('put')
                    @csrf
                    @include('purchase.input')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection