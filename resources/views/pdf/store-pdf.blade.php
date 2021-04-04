<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventories Preview</title>
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
                <h4>Inventories</h4>
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
                                    <th class="text-right">Batch No</th>
                                    <th class="text-right">Manufacture_date</th>
                                    <th class="text-right">Expiry_date</th>
                                    <th class="text-right">MRP</th>
                                </tr>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($stores as $store)
                                <tr>
                                    <td class="text-right">{{$i++}}.</td>
                                    <td>{{$store->product->name}}</td>
                                    <td class="text-right">{{$store->quantity}} {{$store->unit->name}}</td>
                                    <td class="text-right">{{$store->batch_no}}</td>
                                    <td class="text-right">{{$store->mf_date}}</td>
                                    <td class="text-right">{{$store->exp_date}}</td>
                                    <td class="text-right">{{$store->mrp}}</td>
                                </tr>
                                @endforeach
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