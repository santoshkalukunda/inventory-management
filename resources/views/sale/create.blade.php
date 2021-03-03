<div class="ibox">
    <div class="ibox-head">
        <div class="ibox-title">Add Product</div>
    </div>
    <div class="ibox-body">
        <form action="{{route('sales.store',compact('bill'))}}" method="post">
            @csrf
            @include('sale.input')
        </form>
    </div>
</div>