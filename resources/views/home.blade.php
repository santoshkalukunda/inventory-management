@extends('layouts.backend')
@section('title')
    Dashboard
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{$customers->count()}}</h2>
                    <div class="m-b-5">Customers</div><i class="fa fa-users widget-stat-icon"></i>
                    <div><i class="fa fa-level-up m-r-5"></i><small></small></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{$dealers->count()}}</h2>
                    <div class="m-b-5">Dealers</div><i class="fa fa-store widget-stat-icon"></i>
                    <div><i class="fa fa-level-up m-r-5"></i><small></small></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{$totalIncome}}</h2>
                    <div class="m-b-5">TOTAL INCOME</div><i class="fa fa-money-check-alt widget-stat-icon"></i>
                    <div><i class="fa fa-level-up m-r-5"></i><small>Due : {{$dueBill}} </small></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{$totalPurchase}}</h2>
                    <div class="m-b-5">Expenditure</div><i class="fa fa-hand-holding-usd widget-stat-icon"></i>
                    <div><i class="fa fa-level-down m-r-5"></i><small>Due : {{$duePurchase}}</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
