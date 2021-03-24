<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Purchase Bill List</div>
        <div class="text-right">Total Record: {{$purchaseBills->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table-hover table table-bordered">
                <tr>
                    <th>Order_Date</th>
                    <th>Shipping_Date</th>
                    <th>Bill_No.</th>
                    <th>Dealer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>VAT</th>
                    <th>Net_Total</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>User_Name</th>
                    <th colspan="3">Action</th>
                </tr>
                @forelse ($purchaseBills as $purchaseBill)
                <tr class="{{$purchaseBill->status == "incomplete" ? "table-warning" : ''}}"
                    style="white-space:nowrap;">
                    <td>{{$purchaseBill->order_date}}</td>
                    <td>{{$purchaseBill->shipping_date}}</td>
                    <td>{{$purchaseBill->bill_no}}</td>
                    <td><a href="{{route('dealers.show',$purchaseBill->dealer_id)}}">
                            <b>{{$purchaseBill->dealer->name}}</b>
                        </a>
                        <span class=""> <br>{{$purchaseBill->dealer->address}}</span>
                        <span class=""> <br>{{$purchaseBill->dealer->phone}}</span>
                    </td>
                    <td>{{$purchaseBill->total}}</td>
                    <td>{{$purchaseBill->discount}}</td>
                    <td>{{$purchaseBill->vat}}</td>
                    <td>{{$purchaseBill->net_total}}</td>
                    <td>{{$purchaseBill->payment}}</td>
                    <td>{{$purchaseBill->due}}</td>
                    <td>{{$purchaseBill->status}}</td>
                    <td>{{$purchaseBill->user->name}}</td>
                    @if ($purchaseBill->status =="complete")
                    <td>
                        <a href="{{route('purchase-bills.show', $purchaseBill)}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Due Pay"><i
                                class="fa fa-redo"></i></a>
                    </td>
                    @endif
                    <td>
                        <a href="{{route('purchase-bills.create',$purchaseBill)}}" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Edit Bill">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{route('purchase-bills.destroy',$purchaseBill)}}"
                            onsubmit="return confirm('Are you sure to delete bill?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-sm btn-danger fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Bill"></button>
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
{{$purchaseBills->links()}}