<!-- Modal -->
<div class="modal fade" id="staticBackdrop-{{$store->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Edit MRP of [ <b>{{$store->product->name}}</b> ] </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('stores.update',$store)}}" method="post">
                @method('put')
                @csrf
                <div class="modal-body">
                    <input type="number" min="0" name="mrp" class="form-control" value="{{$store->mrp}}" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>