<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Bill List</div>
        <div class="text-right">Total Record: {{$bills->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <tr>
                    <th>Bill_Date</th>
                    <th>Invoice_No.</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>VAT</th>
                    <th>Net_Total</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>User</th>
                    <th colspan="4">Action</th>
                </tr>
                @forelse ($bills as $bill)
                @php
                if ($bill->status == "incomplete"){
                $color = "table-warning";
                }
                elseif($bill->status == "cancel"){
                $color = "table-danger";
                }
                else {
                $color = "";
                }
                @endphp
                <tr class="{{$color}}" style="white-space:nowrap;">
                    <td>{{$bill->date}}</td>
                    <td>{{$bill->invoice_no}}</td>
                    <td><a href="{{route('customers.show',$bill->customer_id)}}">
                            <b>{{$bill->customer->name}}</b></a>
                        <span class=""> <br>{{$bill->customer->address}}</span>
                        <span class=""> <br>{{$bill->customer->phone}}</span>
                    </td>
                    <td class="text-right">{{$bill->total}}</td>
                    <td class="text-right">
                        @if ($bill->discount)
                        {{$bill->discount }}{{$bill->discount_in == "fixed" ? '' : "%"}}
                        @endif
                     </td>
                    <td class="text-right">{{$bill->vat}}</td>
                    <td class="text-right">{{$bill->net_total}}</td>
                    <td class="text-right">{{$bill->payment}}</td>
                    <td class="text-right">{{$bill->due}}</td>
                    <td>{{$bill->status}}</td>
                    <td>{{$bill->user->name}}</td>
                    @if ($bill->status =="complete")
                    <td>
                        <a href="{{route('bills.show', $bill)}}" class="btn btn-primary" data-toggle="tooltip"
                            data-placement="top" title="Due Pay"><i class="fa fa-redo"></i></a>
                    </td>
                    @endif
                    <td>
                        <a href="{{route('bills.create', compact('bill'))}}" class="btn btn-success"
                            data-toggle="tooltip" data-placement="top" title="Edit Bill"><i class="fa fa-edit"></i></a>
                    </td>
                    @if ($bill->status =="complete")
                    <td>
                        <form action="{{route('bills.cancel',$bill)}}"
                            onsubmit="return confirm('Are you sure to cancel bill?')" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-sm btn-danger fa fa-window-close" data-toggle="tooltip"
                                data-placement="top" title="Cancel Bill"></button>
                        </form>
                    </td>
                    @endif

                    <td>
                        <form action="{{route('bills.destroy',$bill)}}"
                            onsubmit="return confirm('Are you sure to delete bill?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-sm btn-danger fa fa-trash" data-toggle="tooltip"
                                data-placement="top" title="Delete Bill"></button>
                        </form>
                    </td>

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
{{$bills->links()}}