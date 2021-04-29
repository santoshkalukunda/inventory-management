<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Sale Due Pay List</div>
        <div class="text-right">Total Record: {{$saleDues->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Due Amount</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>User Name</th>
                    <th colspan="2">Action</th>
                </tr>
                @forelse ($saleDues as $saleDue)
                <tr>
                    <td>{{$saleDue->date}}</td>
                    <td> {{$saleDue->customer->name}}</td>
                    <td>{{$saleDue->due_amount}}</td>
                    <td>{{$saleDue->payment}}</td>
                    <td>{{$saleDue->due}}</td>
                    <td>{{$saleDue->user->name}}</td>
                    <td> 
                        <a href="{{route('bills.create',$saleDue->bill_id)}}" class="fa fa-eye btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Bill"></a>
                    </td>
                    <td>
                        <form action="{{route('sale-dues.destroy',$saleDue)}}"
                            onsubmit="return confirm('Are you sure to delete due Payment?')" method="POST" class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger fa fa-trash-alt" data-toggle="tooltip" data-placement="top" title="Delete Due"></button>
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
{{$saleDues->links()}}