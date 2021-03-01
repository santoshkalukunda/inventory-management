<!-- Modal -->
<div class="modal fade" id="new-bill" tabindex="-1" role="dialog" aria-labelledby="new-billTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Customer Select</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <a href="{{route('customers.create')}}" class="btn btn-primary mb-2 form-control"> <i class="fa fa-plus"></i>
          New
          Customer
        </a>
        <form action="{{route('customers.find')}}" method="post">
          @csrf
          <label for="customer_id">Customer Name</label>br
          <select class="selectpicker form-control @error('customer_id') is-invalid @enderror" name="customer_id"
            id="product" data-live-search="true" data-size="4">
            <option value="" selected>Select Customer</option>
            @foreach ($customers as $customer)
            <option value="{{$customer->id}}" data-content="<b>{{$customer->name}}</b>
                <br>{{$customer->address}}
                <br>{{$customer->phone}}
                <br>{{$customer->pan_vat}}
                "></option>
            @endforeach
          </select>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="submit"  class="btn btn-primary" value="Proceed">
        </form>
      </div>
    </div>
  </div>
</div>
</div>