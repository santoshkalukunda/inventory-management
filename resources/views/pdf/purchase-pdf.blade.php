<style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    </style>
<div class="row">
    <div class="col-md-12 justify-content-center">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Purchase List</div>
            </div>
            <div class="ibox-body">
                <div class="table-responsive" style="font-size: 7px;">
                    <table class="table table-hover table-bordered">
                        <tr class="text-center bg-light">
                            <th>Order_Date</th>
                            <th>Shipping_Date</th>
                            <th>Bill_No.</th>
                            <th>Dealer</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model_No.</th>
                            <th>Serial_No.</th>
                            <th>Batch_No.</th>
                            <th>Manufacture_date</th>
                            <th>Expiry_date</th>
                            <th>Quantity</th>
                            <th class="mx-2">Uint </th>
                            <th>Rate</th>
                            <th>Discount</th>
                            <th>TAX/VAT</th>
                            <th>Total</th>
                            <th>Pyament</th>
                            <th>Due</th>
                            <th>MRP</th>
                        </tr>
                        @forelse ($purchases as $purchase)
                        <tr >
                            <td>{{$purchase->order_date}}</td>
                            <td>{{$purchase->shipping_date}}</td>
                            <td class="text-right">{{$purchase->bill_no}}</td>
                            <td>
                                <a href="{{route('dealers.show',$purchase->dealer)}}"
                                    class="font-14"><b>{{$purchase->dealer->name}}</b></a>
                                <span class=""> <br>{{$purchase->dealer->address}}</span>
                                <span class=""> <br><b>PAN/VAT:</b>{{$purchase->dealer->pan_vat}}</span>
                            </td>
                            <td>
                                {{$purchase->product->code}}
                                <br>
                                {{$purchase->product->name}}
                            </td>
                            {{-- <td>{{$purchase->category->name}}</td> --}}
                            {{-- <td>{{$purchase->brand->name}}</td> --}}
                            <td>{{$purchase->model_no}}</td>
                            <td>{{$purchase->serial_no}}</td>
                            <td>{{$purchase->batch_no}}</td>
                            <td>{{$purchase->mf_date}}</td>
                            <td>{{$purchase->exp_date}}</td>
                            <td class="text-right">{{$purchase->quantity}}</td>
                            <td>{{$purchase->unit->name}}</td>
                            <td class="text-right">{{number_format((float)$purchase->rate,2,'.', '')}}</td>
                            <td class="text-right">
                                @if ($purchase->discount)    
                                {{$purchase->discount}}{{$purchase->discount_in == "fixed" ? '' : '%'}}
                                @endif
                            </td>
                            <td class="text-right">{{$purchase->vat}}</td>
                            <td class="text-right">{{number_format((float)$purchase->total,2,'.', '')}}</td>
                            <td class="text-right">{{number_format((float)$purchase->payment,2,'.', '')}}</td>
                            <td class="text-right">{{number_format((float)$purchase->due,2,'.', '')}}</td>
                            <td class="text-right">{{number_format((float)$purchase->mrp,2,'.', '')}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="40" class=" text-center text-danger">*Data Not Found !!!</td>
                        </tr>
                        @endforelse

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