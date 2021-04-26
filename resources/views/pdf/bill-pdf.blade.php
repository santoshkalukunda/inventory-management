<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Preview</title>
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
            font-size: 13px;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 4px;
        }

        body {
            margin: 5px 40px;
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
                <h4>INVOICE</h4>
            </div>
            <div class="col-md-6">
                <span><b>Name:</b> {{$bill->customer->name}} <br></span>
                <span><b>Address:</b> {{$bill->customer->address}} <br></span>
                @if ($bill->customer->phone)
                <span><b>Phone:</b> {{$bill->customer->phone}}<br></span>
                @endif
                @if ($bill->customer->email)
                <span><b>Email:</b>{{$bill->customer->email}} <br></span>
                @endif
                @if ($bill->customer->pan_vat)
                <span><b>PAN/VAT:</b> {{$bill->customer->pan_vat}}</span>
                @endif
            </div>
            <div class="col-md-6 text-right">
                <b>Invoice No.:</b> {{$bill->invoice_no}} <br>
                <b>Transaction Date:</b> {{$bill->date}} <br>
                <b>Invoice Issue Date:</b> <span>{{date('Y/m/d')}} <br>
                    {{date('h:i:sa')}}</span>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-12 my-3">
                <div class="ibox">
                    <div class="ibox-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <tr class="text-center bg-light">
                                    <th>SN</th>
                                    <th>Particulars</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-right">Discount</th>
                                    <th class="text-right">TAX/VAT</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($sales as $sale)
                                <tr>
                                    <td class="text-right">{{$i++}}.</td>
                                    <td>{{$sale->store->product->name}}</td>
                                    <td class="text-right">{{$sale->quantity}} {{$sale->unit->name}}</td>
                                    <td class="text-right">{{$sale->rate}}</td>
                                    <td class="text-right">
                                        {{$sale->discount}}
                                    </td>
                                    <td class="text-right">{{$sale->vat}}</td>
                                    <td class="text-right">{{round($sale->total, 2)}}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="5" rowspan="6">
                                        <span style="text-transform: capitalize"><b>In-word Rs.:</b>
                                            {{Terbilang::make( round($bill->net_total))}} Only.</span>
                                    </td>
                                    <td class="text-right">Total</td>
                                    <td class="text-right">{{round($bill->total,2)}}</td>
                                </tr>

                                <tr>
                                    <td class="text-right">Discount</td>
                                    <td class="text-right">{{$bill->discount ?? "-"}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">VAT</td>
                                    <td class="text-right">{{$bill->vat ?? "-"}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Grand Total</td>
                                    <td class="text-right">{{round($bill->net_total,2)}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Pyment</td>
                                    <td class="text-right">{{$bill->payment}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Due</td>
                                    <td class="text-right">{{round($bill->due)}}</td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-12 text-right" style="margin-top: 20px; text-transform: capitalize">
                            {{Auth::user()->name}}
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