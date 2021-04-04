<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Product List</title>
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
                <h4>Purchase Product List</h4>
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
                                    <th>Bill No.</th>
                                    <th>Date</th>
                                    <th>Dealer</th>
                                    <th>Product</th>
                                    <th>Batch No</th>
                                    <th>MF. date</th>
                                    <th>Exp. date</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Disc. %</th>
                                    <th>VAT %</th>
                                    <th>Total</th>
                                    <th>MRP</th>
                                </tr>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($purchases as $purchase)
                                <tr>
                                    <td class="text-right">{{$i++}}.</td>
                                    <td>{{$purchase->purchaseBill->bill_no}}</td>
                                    <td>
                                        <div><b>OD-</b> ({{$purchase->purchaseBill->order_date}})</div>
                                        <div><b>SD-</b>({{$purchase->purchaseBill->shipping_date}})</div>
                                    </td>
                                    <td>
                                        <b>{{$purchase->dealer->name}}</b>
                                        <span class=""> <br>{{$purchase->dealer->address}}</span>
                                        <span class=""> <br>{{$purchase->dealer->pan_vat}}</span>
                                    </td>
                                    <td>
                                        {{$purchase->product->code}}
                                        <br>
                                        <b>{{$purchase->product->name}}</b>
                                        <br>
                                        {{$purchase->product->category->name}}
                                        <br>
                                        {{$purchase->product->brand->name}}
                                        <br>
                                        {{$purchase->model_no}}
                                        <br>
                                        {{$purchase->serial_no}}
                                    </td>
                                    <td>{{$purchase->batch_no}}</td>
                                    <td>{{$purchase->mf_date}}</td>
                                    <td>{{$purchase->exp_date}}</td>
                                    <td class="text-right">{{$purchase->quantity}} {{$purchase->unit->name}}</td>
                                    <td class="text-right">{{number_format((float)$purchase->rate,2,'.', '')}}</td>
                                    <td class="text-right">{{$purchase->discount}}</td>
                                    <td class="text-right">{{$purchase->vat}}</td>
                                    <td class="text-right">{{number_format((float)$purchase->total,2,'.', '')}}</td>
                                    <td class="text-right">{{number_format((float)$purchase->mrp,2,'.', '')}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="12" class="text-right"> <b>Grand Total</b> </td>
                                    <td class="text-right">{{number_format((float)$total,2,'.', '')}}</td>
                                    <td></td>
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