@push('style')
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush
<div class="row">
    <div class="col-md-4 form-group">
        <label for="product_id" class="required">Product Name</label>
        <select class="selectpicker form-control @error('product_id') is-invalid @enderror" name="product_id"
            id="product" data-live-search="true" data-size="4">
            <option value="" selected>Select Product</option>
            @foreach ($products as $product)
            <option value="{{$product->id}}" data-content="<span><b>{{$product->name}}</b>
                    <br>{{$product->code}}
                    <br>{{$product->category->name}}
                    <br>{{$product->brand->name}}
                    <br>{{$product->model_no}}
                    <br>{{$product->serial_no}}
                </span>">{{$product->name}}</option>
            @endforeach
        </select>
        @error('product_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="mf_date">Manufacture Date</label>
        <input type="date" class="form-control @error('mf_date') is-invalid @enderror" name="mf_date"
            value="{{old('mf_date')}}" id="mf_date" placeholder="Batch No.">
        @error('mf_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="exp_date">Expiry Date</label>
        <input type="date" class="form-control @error('exp_date') is-invalid @enderror" name="exp_date"
            value="{{old('exp_date')}}" id="exp_date" placeholder="Batch No.">
        @error('exp_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="batch_no">Batch No.</label>
        <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no"
            value="{{old('batch_no')}}" id="batch_no" placeholder="Batch No.">
        @error('batch_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="quantity" class="required">Quantity</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('quantity') is-invalid @enderror"
            name="quantity" value="{{old('quantity')}}" id="quantity" placeholder="Quantity" onkeyup="fun()">
        @error('quantity')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="unit_id" class="required">Unit</label>
        <select class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id" id="unit_id"
            data-live-search="true" data-size="5">
            <option value="" selected>Select Unit</option>
            @foreach ($units as $unit)
            <option value="{{$unit->id}}"> {{$unit->name}}
            </option>
            @endforeach
        </select>
        @error('unit_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="rate" class="required">Rate</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('rate') is-invalid @enderror"
            name="rate" value="{{old('rate')}}" id="rate" placeholder="Rate Rs." onkeyup="fun()">
        @error('rate')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="discount">Discount %</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('discount') is-invalid @enderror"
            name="discount" value="{{old('discount')}}" id="discount" placeholder="Discount in %" onkeyup="fun()">
        @error('discount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="vat">VAT %</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('vat') is-invalid @enderror"
            name="vat" value="{{old('vat')}}" id="vat" placeholder="VAT in %" onkeyup="fun()">
        @error('vat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="total">Net-Total</label>
        <input step="any" type="number" min="0" class="form-control text-right @error('total') is-invalid @enderror"
            name="total" value="{{old('total')}}" id="total" placeholder="Net-Total">
        @error('total')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="mrp" class="required">MRP</label>
        <input type="number" min="0" class="form-control text-right @error('mrp') is-invalid @enderror" name="mrp"
            value="{{old('mrp')}}" id="mrp" placeholder="MRP">
        @error('mrp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="form-group col-md-2">
        <button type="submit" class="btn btn-success form-control btn-rounded">Save</button>
    </div>
</div>
<script>
    function fun(){
    var  quantity= document.getElementById("quantity").value;
    var rate = document.getElementById("rate").value;
    var discount = document.getElementById("discount").value;
    var vat = document.getElementById("vat").value;
    var due = document.getElementById("due").value;
    var calculate = (quantity * rate);
     calculate = calculate - ((calculate * (discount)/100));
     var calculate = calculate + ((calculate * (vat)/100));
    document.getElementById("total").value = calculate.toFixed(2);
      }
</script>