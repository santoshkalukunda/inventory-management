<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill Lists</title>
    <style>
        .col-md-6 {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
            margin: 5px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        body {
            margin: 8px 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-12 text-center" style="">
                <b style="font-size: 20px;">{{$company->name}}</b>
                <div>{{$company->address}}</div>
                <div>{{$company->contact}}, {{$company->email}}</div>
                <div>{{$company->website}}</div>
                <div><b>{{$company->type}} :</b>{{$company->pan_vat}}</div>
                <h4>Bill Lists</h4>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12 my-3">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tr class="text-center bg-light">
                                    <th rowspan="2">SN</th>
                                    <th rowspan="2">Date</th>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Customer</th>
                                    <th colspan="4">Product</th>
                                    <th rowspan="2">Total</th>
                                    <th rowspan="2">Disc. %</th>
                                    <th rowspan="2">VAT %</th>
                                    <th rowspan="2">Net_Total</th>
                                    <th rowspan="2">Payment</th>
                                    <th rowspan="2">Due</th>

                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <th>Qnt.</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                </tr>
                                @php
                                $i = 1;
                                $netTotal = 0;
                                $paymentTotal = 0;
                                $dueTotal = 0;
                                @endphp
                                @foreach ($bills as $bill)
                                @php
                                $sales = $bill->sale()->with('store', 'unit', 'product')->get();
                                $rows = $sales->count();
                                $netTotal = $netTotal + $bill->net_total;
                                $paymentTotal = $paymentTotal + $bill->payment;
                                $dueTotal = $dueTotal + $bill->due;
                                @endphp
                                <tr>
                                    <td class="text-right" rowspan="{{$rows}}">{{$i++}}.</td>
                                    <td rowspan="{{$rows}}">{{$bill->date}}</td>
                                    <td rowspan="{{$rows}}">{{$bill->invoice_no}}</td>
                                    <td rowspan="{{$rows}}">
                                        <b>{{$bill->customer->name}}</b></a>
                                        <span class=""> <br>{{$bill->customer->address}}</span>
                                        <span class=""> <br>{{$bill->customer->phone}}</span>
                                    </td>
                                    @php
                                    $j=1;
                                    @endphp
                                    @foreach ($sales as $sale)
                                    @if($loop->first)
                                    <td>
                                        {{$j++}}. <b>{{$sale->store->product->name}}</b>
                                        @if ($sale->store->mf_date)
                                        <div>MFD-({{$sale->store->mf_date}})</div>
                                        @endif
                                        @if ($sale->store->exp_date)
                                        <div>ExpD-({{$sale->store->exp_date}})</div>
                                        @endif
                                    </td>
                                    <td class="text-right">{{$sale->quantity}} </td>
                                    <td> {{$sale->unit->name}}</td>
                                    <td class="text-right">{{$sale->rate}}</td>
                                    @endif
                                    @endforeach
                                    @if (!$rows)
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @endif
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->total}}</td>
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->discount  }}</td>
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->vat}}</td>
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->net_total}}</td>
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->payment}}</td>
                                    <td class="text-right" rowspan="{{$rows}}">{{$bill->due}}</td>
                                </tr>

                                @foreach ($sales as $sale)
                          
                                @if (!$loop->first)
                                <tr>
                                    <td>{{$j++}}. <b>{{$sale->store->product->name}}</b></td>
                                    <td class="text-right">{{$sale->quantity}}</td>
                                    <td> {{$sale->unit->name}}</td>
                                    <td class="text-right">{{$sale->rate}}</td>
                                </tr>
                                @endif
                                @endforeach
                                @endforeach
                                @php
                         
                                @endphp
                                <tr>
                                    <td colspan="11" class="text-right"><b>Grand Total</b></td>
                                    <td class="text-right">{{$netTotal}}</td>
                                    <td class="text-right">{{$paymentTotal}}</td>
                                    <td class="text-right">{{$dueTotal}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/php">
                if ( isset($pdf) ) {
                $font = Font_Metrics::get_font("helvetica", "bold");
                $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
            }
        </script>
        </div>
    </div>
</body>

</html>