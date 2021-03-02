<div class="ibox">
    <div class="ibox-head d-flex">
        <div class="ibox-title">Purchase Due Pay List</div>
        <div class="text-right">Total Record: {{$purchaseDues->total()}}</div>
    </div>
    <div class="ibox-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Date</th>
                    <th>Dealer</th>
                    <th>Due Amount</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th colspan="2">Action</th>
                </tr>
                @forelse ($purchaseDues as $purchaseDue)
                <tr>
                    <td>{{$purchaseDue->date}}</td>
                    <td> {{$purchaseDue->dealer->name}}</td>
                    <td>{{$purchaseDue->due_amount}}</td>
                    <td>{{$purchaseDue->payment}}</td>
                    <td>{{$purchaseDue->due}}</td>
                    <td>
                        <a href="{{route('purchase.show',$purchaseDue->purchase_id)}}" class="text-muted"><i
                                class="fa fa-eye"></i></a>
                    </td>
                    <td>
                        <form action="{{route('purchase-dues.destroy',$purchaseDue)}}"
                            onsubmit="return confirm('Are you sure to delete due Payment?')" method="POST"
                            class="d-inline">
                            @csrf
                            @method('delete')
                            <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                    class="fa fa-trash-alt"></i></button>
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
{{$purchaseDues->links()}}