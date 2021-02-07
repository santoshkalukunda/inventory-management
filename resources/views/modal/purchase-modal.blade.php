<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dealer Select</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('purchase.find')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dealer_id" class="required">Dealer Name</label>
                        <select class="selectpicker form-control @error('dealer_id') is-invalid @enderror"
                        name="dealer_id" id="product_id" data-live-search="true" data-size="5">
                        <option value="" selected>Select Dealer</option>
                        @foreach ($dealers as $dealer)
                        <option value="{{$dealer->id}}" data-subtext="{{$dealer->address}}"> <a
                            href="/">{{$dealer->name}}</a>
                            </option>
                            
                            @endforeach
                        </select>
                    </div>
                    <a href="{{route('dealers.create')}}">New Dealer Create</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Proceed">
                </div>
            </form>
        </div>
    </div>
</div>