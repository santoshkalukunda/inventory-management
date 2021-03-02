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
                        @php
                        $customer=$bill->customer_id;
                        @endphp
                        <a href="{{route('bills.show', $bill)}}" class="text-muted"><i class="fa fa-eye"></i></a>
                    </td>
                    @endif
                    <td>
                        @php
                        $customer=$bill->customer_id;
                        @endphp
                        <a href="{{route('bills.create', compact('customer','bill'))}}" class="text-muted"><i
                                class="fa fa-edit"></i></a>
                    </td>
                    @if ($bill->status =="complete")
                    <td>
                        <form action="{{route('bills.cancel',$bill)}}"
                            onsubmit="return confirm('Are you sure to cancel bill?')" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                    class="fa fa-window-close"></i></button>
                        </form>
                    </td>
                    @endif
                    @if ($bill->status =="incomplete")
                    <td>
                        <form action="{{route('bills.destroy',$bill)}}"
                            onsubmit="return confirm('Are you sure to delete bill?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                    class="fa fa-trash-alt"></i></button>
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