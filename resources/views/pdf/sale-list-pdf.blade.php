<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Product List</title>
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
                <h4>Sales Product List</h4>
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
                                    <th>Date</th>
                                    <th>Invoice No.</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Batch_No.</th>
                                    <th>Mf_date</th>
                                    <th>Exp._date</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Rate</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">Discount</th>
                                    <th class="text-right">VAT</th>
                                    <th class="text-right">Net-Total</th>
                                </tr>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($sales as $sale)
                                <tr>
                                    <td class="text-right">{{$i++}}.</td>
                                    <td>{{$sale->date}}</td>
                                    <td>{{$sale->invoice_no}}</td>
                                    <td>
                                        <b>{{$sale->customer->name}}</b></a>
                                        <span class=""> <br>{{$sale->customer->address}}</span>
                                        <span class=""> <br>{{$sale->customer->phone}}</span>
                                        <span class=""> <br>{{$sale->customer->pan_vat}}</span>
                                    </td>
                                    <td>
                                        {{$sale->store->product->code}}<br>
                                        <b>{{$sale->store->product->name}}</b><br>
                                        {{$sale->store->product->category->name}}<br>
                                        {{$sale->store->product->brand->name}}<br>
                                        @if ($sale->store->product->model_no)
                                        <b>Model: </b>{{$sale->store->product->model_no}}<br>
                                        @endif
                                    </td>
                                    <td>{{$sale->store->batch_no}} </td>
                                    <td>{{$sale->store->mf_date}}</td>
                                    <td>{{$sale->store->exp_date}} </td>
                                    <td class="text-right">{{$sale->quantity}} {{$sale->unit->name}}</td>
                                    <td class="text-right">{{number_format((float)$sale->rate,2,'.', '')}}</td>
                                    <td class="text-right">{{$sale->quantity * $sale->rate }}</td>
                                    <td class="text-right">
                                        @if ($sale->discount)    
                                        {{$sale->discount}}{{$sale->discount_in == "fixed" ? "" : '%'}}
                                        @endif
                                    </td>
                                    <td class="text-right">{{$sale->vat}}</td>
                                    <td class="text-right">{{number_format((float)$sale->total,2,'.', '')}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="13" class="text-right"> <b> Grand Total</b></td>
                                    <td class="text-right">{{number_format((float)$total,2,'.', '')}}</td>
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