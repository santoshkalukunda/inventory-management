<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Purchase Due Pay List</div>
        <div class="text-right">Total Record: {{$purchaseBillDues->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Date</th>
                    <th>Dealer</th>
                    <th>Due_Amount</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th colspan="2">Action</th>
                </tr>
                @forelse ($purchaseBillDues as $purchaseBillDue)
                <tr>
                    <td>{{$purchaseBillDue->date}}</td>
                    <td> {{$purchaseBillDue->dealer->name}}</td>
                    <td>{{$purchaseBillDue->due_amount}}</td>
                    <td>{{$purchaseBillDue->payment}}</td>
                    <td>{{$purchaseBillDue->due}}</td>
                    <td>
                        <a href="{{route('purchase-bills.create',$purchaseBillDue->purchase_bill_id)}}" class="fa fa-eye btn btn-primary" data-toggle="tooltip" data-placement="top" title="Show bill"></a>
                    </td>
                    <td>
                        <form action="{{route('purchase-dues.destroy',$purchaseBillDue)}}"
                            onsubmit="return confirm('Are you sure to delete due Payment?')" method="POST"
                            class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="fa fa-trash-alt btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Due"></button>
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
{{$purchaseBillDues->links()}}