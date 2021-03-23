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
                    <h2 class="m-b-5 font-strong">{{ round($totalIncome, 2)}}</h2>
                    <div class="m-b-5">TOTAL INCOME</div><i class="fa fa-money-check-alt widget-stat-icon"></i>
                    <div><i class="fa fa-level-up m-r-5"></i><small>Due : {{ round($dueBill, 2)}} </small></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong">{{round($totalPurchase, 2)}}</h2>
                    <div class="m-b-5">Expenditure</div><i class="fa fa-hand-holding-usd widget-stat-icon"></i>
                    <div><i class="fa fa-level-down m-r-5"></i><small>Due : {{ round($duePurchase, 2)}}</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">{{ __('Daily Sales') }}</div>
                <div class="card-body">
                    <div style="width:100%;">
                        {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">{{ __('Monthely Purchase') }}</div>
                <div class="card-body">
                    <div style="width:100%;">
                        {!! $purchaseChart->render() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">{{ __('Yearly Purchase And Sale') }}</div>
                <div class="card-body">
                    <div style="width:100%;">
                        {!! $barChart->render() !!}
                    </div>
                </div>
            </div>
        </div>
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