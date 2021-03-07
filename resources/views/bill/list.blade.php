<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Bill List</div>
        <div class="text-right">Total Record: {{$bills->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Bill Date</th>
                    <th>Invoice No.</th>
                    <th>Customer</th>
                    <th>Net Total</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>User Name</th>
                    <th colspan="4">Action</th>
                </tr>
                @forelse ($bills as $bill)
                <tr>
                    <td>{{$bill->date}}</td>
                    <td>{{$bill->invoice_no}}</td>
                    <td><a href="{{route('customers.show',$bill->customer_id)}}">
                            <b>{{$bill->customer->name}}</b></a>
                        <span class=""> <br>{{$bill->customer->address}}</span>
                        <span class=""> <br>{{$bill->customer->phone}}</span>
                    </td>
                    <td>{{$bill->net_total}}</td>
                    <td>{{$bill->payment}}</td>
                    <td>{{$bill->due}}</td>
                    <td>{{$bill->status}}</td>
                    <td>{{$bill->user->name}}</td>
                    @if ($bill->status =="complete")
                    <td>
                        <a href="{{route('bills.show', $bill)}}" class="btn btn-primary">Due Pay</a>
                    </td>
                    @endif
                    <td>
                        <a href="{{route('bills.create', compact('bill'))}}" class="btn btn-success">Edit</a>
                    </td>
                    @if ($bill->status =="complete")
                    <td>
                        <form action="{{route('bills.cancel',$bill)}}"
                            onsubmit="return confirm('Are you sure to cancel bill?')" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-sm btn-danger">Cancel</button>
                        </form>
                    </td>
                    @endif
                    @if ($bill->status =="incomplete")
                    <td>
                        <form action="{{route('bills.destroy',$bill)}}"
                            onsubmit="return confirm('Are you sure to delete bill?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-sm btn-danger ">Delete</button>
                        </form>
                    </td>
                    @endif
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