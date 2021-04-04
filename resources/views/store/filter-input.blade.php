<div class="row">
    <div class="col-md-3 form-group">
        <label for="product_id">Product Name</label>
        <select class="selectpicker form-control @error('product_id') is-invalid @enderror"
            name="product_id" id="product" data-live-search="true" data-size="4">
            <option value="" selected>Select Product</option>
            @foreach ($products as $product)
            <option value="{{$product->id}}" data-content="<span><b>{{$product->name}}</b>
                <br>{{$product->code}}
                <br>{{$product->category->name}}
                <br>{{$product->brand->name}}
                <br>{{$product->model_no}}
            </span>">
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label for="quantity_min">Quantity Minimun</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('quantity_min') is-invalid @enderror"
            name="quantity_min" id="quantity_min" placeholder="Quantity Min">
    </div>
    <div class="col-md-2 form-group">
        <label for="quantity_max">Quantity Maximum</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('quantity_max') is-invalid @enderror"
            name="quantity_max" id="quantity_max" placeholder="Quantity Max">
    </div>
    <div class="col-md-2 form-group">
        <label for="unit_id">Unit</label>
        <select class="selectpicker form-control @error('unit_id') is-invalid @enderror"
            name="unit_id" id="unit_id" data-live-search="true" data-size="5">
            <option value="" selected>Select Unit</option>
            @foreach ($units as $unit)
            <option value="{{$unit->id}}">
                {{$unit->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label for="batch_no">Batch No.</label>
        <input type="text" class="form-control @error('batch_no') is-invalid @enderror"
            name="batch_no" id="batch_no" placeholder="Batch No.">
    </div>
    <div class="col-md-3 form-group">
        <label for="mf_date_from">Manufacture Date From</label>
        <input type="date" class="form-control @error('mf_date_from') is-invalid @enderror"
            name="mf_date_from" id="mf_date_from">
    </div>
    <div class="col-md-3 form-group">
        <label for="mf_date_to">Manufacture Date to</label>
        <input type="date" class="form-control @error('mf_date_to') is-invalid @enderror"
            name="mf_date_to" id="mf_date_to">
    </div>
    <div class="col-md-3 form-group">
        <label for="exp_date_from"> Expiry Date From</label>
        <input type="date" class="form-control @error('exp_date_from') is-invalid @enderror"
            name="exp_date_from" id="exp_date_from">
    </div>
    <div class="col-md-3 form-group">
        <label for="exp_date_to"> Expiry Date To</label>
        <input type="date" class="form-control @error('exp_date_to') is-invalid @enderror"
            name="exp_date_to" id="exp_date_to">
    </div>
    <div class="col-md-2 form-group">
        <label for="mrp_min">MRP Min.</label>
        <input type="number" min="0"
            class="form-control text-right @error('mrp_min') is-invalid @enderror"
            name="mrp_min" id="mrp_min" placeholder="MRP Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="mrp_max">MRP Max.</label>
        <input type="number" min="0"
            class="form-control text-right @error('mrp_max') is-invalid @enderror"
            name="mrp_max" id="mrp_max" placeholder="MRP Max.">
    </div>
</div>