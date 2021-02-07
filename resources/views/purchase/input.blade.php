<div class="row">
    <div class="col-md-3 form-group">
        <label for="order_date" class="required">Order Date</label>
        <input type="date" class="form-control @error('order_date') is-invalid @enderror" value="{{old('order_date',$purchase->order_date)}}" name="order_date" id="order_date" placeholder="Order Date">
        @error('order_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="shpping_date" class="required">Shipping Date</label>
        <input type="date" class="form-control @error('shipping_date') is-invalid @enderror" value="{{old('shipping_date',$purchase->shipping_date)}}" name="shipping_date" id="shipping_date" placeholder="Shipping Date">
        @error('shipping_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="bill_no" class="required">Bill No.</label>
        <input type="number" min="0" class="form-control @error('bill_no') is-invalid @enderror" value="{{old('bill_no',$purchase->bill_no)}}" name="bill_no" id="bill_no" placeholder="Bill No." >
        @error('bill_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="product_id" class="required">Product Name</label>
        <select  class="selectpicker form-control @error('product_id') is-invalid @enderror" name="product_id"   id="product" data-live-search="true" data-size="5">
            <option value="" selected>Select Product</option>
            @foreach ($products as $product)
                <option value="{{$product->id}}" data-subtext="{{$product->code}}" {{$product->id == $purchase->product_id ? 'selected' : ''}}> {{$product->name}}</option>
            @endforeach
          </select>
        @error('product_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="category_id" class="required">Category Name</label>
        <select  class="selectpicker form-control @error('category_id') is-invalid @enderror" name="category_id"   id="product_id" data-live-search="true" data-size="5">
            <option value="" selected>Select Category</option>
            @foreach ($categories as $category)
                <option value="{{$category->id}}" {{$category->id == $purchase->category_id ? 'selected' : ''}}> {{$category->name}}</option>
            @endforeach
          </select>
        @error('category_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="brand_id" class="required">Brand Name</label>
        <select  class="selectpicker form-control @error('brand_id') is-invalid @enderror" name="brand_id"   id="brand_id" data-live-search="true" data-size="5">
            <option value="" selected>Select Brand</option>
            @foreach ($brands as $brand)
                <option value="{{$brand->id}}" {{$brand->id == $purchase->brand_id ? 'selected' : ''}}> {{$brand->name}}</option>
            @endforeach
          </select>
        @error('brand_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="model_no">Model No.</label>
        <input type="text" class="form-control @error('model_no') is-invalid @enderror" name="model_no" value="{{old('model_no',$purchase->model_no)}}" id="model_no" placeholder="Model No.">
        @error('model_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="serial_no">Serial No.</label>
        <input type="text" class="form-control @error('serial_no') is-invalid @enderror" name="serial_no" value="{{old('serial_no',$purchase->serial_no)}}" id="serial_no" placeholder="Model No.">
        @error('serial_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="batch_no">Batch No.</label>
        <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no" value="{{old('batch_no',$purchase->batch_no)}}" id="batch_no" placeholder="Batch No.">
        @error('batch_no')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="mf_date">Manufacture Date</label>
        <input type="date" class="form-control @error('mf_date') is-invalid @enderror" name="mf_date" value="{{old('mf_date',$purchase->mf_date)}}" id="mf_date" placeholder="Batch No.">
        @error('mf_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-3 form-group">
        <label for="exp_date">Expiry Date</label>
        <input type="date" class="form-control @error('exp_date') is-invalid @enderror" name="exp_date" value="{{old('exp_date',$purchase->exp_date)}}" id="exp_date" placeholder="Batch No.">
        @error('exp_date')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="quantity" class="required">Quantity</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('quantity') is-invalid @enderror" name="quantity" value="{{old('quantity',$purchase->quantity)}}" id="quantity" placeholder="Quantity" onkeyup="fun()">
        @error('quantity')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="unit_id" class="required">Unit</label>
        <select  class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id"   id="unit_id" data-live-search="true" data-size="5">
            <option value="" selected>Select Unit</option>
            @foreach ($units as $unit)
                <option value="{{$unit->id}}" {{$unit->id == $purchase->unit_id ? 'selected' : ''}}> {{$unit->name}}</option>
            @endforeach
          </select>
        @error('unit_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="rate" class="required">Rate</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('rate') is-invalid @enderror" name="rate" value="{{old('rate',$purchase->rate)}}" id="rate" placeholder="Rate Rs." onkeyup="fun()">
        @error('rate')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="discount">Discount in %</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('discount') is-invalid @enderror" name="discount" value="{{old('discount',$purchase->discount)}}" id="discount" placeholder="Discount in %" onkeyup="fun()">
        @error('discount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="vat">VAT in %</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('vat') is-invalid @enderror" name="vat" value="{{old('vat',$purchase->vat)}}" id="vat" placeholder="VAT in %" onkeyup="fun()">
        @error('vat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="total">Net-Total</label>
        <input  step="any" type="number" min="0" class="form-control text-right @error('total') is-invalid @enderror" name="total" value="{{old('total',$purchase->total)}}" id="total" placeholder="Net-Total" readonly>
        @error('total')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
  
    <div class="col-md-2 form-group">
        <label for="payment" class="required">Payment Amount</label>
        <input type="number" min="0" step="any" class="form-control text-right @error('payment') is-invalid @enderror" name="payment" value="{{old('payment',$purchase->payment)}}" id="payment" placeholder="Payment Rs." onkeyup="fun()">
        @error('payment')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="due">Due Amount</label>
        <input type="number" step="any" class="form-control text-right @error('due') is-invalid @enderror" name="due" value="{{old('due',$purchase->due)}}" id="due" placeholder="Due Amount" readonly>
        @error('due')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-2 form-group">
        <label for="mrp">MRP</label>
        <input type="number" min="0" class="form-control text-right @error('mrp') is-invalid @enderror" name="mrp" value="{{old('mrp',$purchase->mrp)}}" id="mrp" placeholder="MRP">
        @error('mrp')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-12">
        <label for="details">Other details</label>
        <textarea type="text" id="details" name="details"
            class="form-control  @error('details') is-invalid @enderror"
        rows="2" placeholder="Details...">{{old('details',$purchase->details)}}</textarea>
        @error('details')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-2" >
        <a href="{{route('purchase.index')}}" class="btn btn-danger form-control btn-rounded">Back</a>
    </div>
    <div class="form-group col-md-2" >
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
    var payment = document.getElementById("payment").value;
    var calculate = (quantity * rate);
     calculate = calculate - ((calculate * (discount)/100))+((calculate * (vat)/100));
    document.getElementById("total").value = calculate.toFixed(2);
    document.getElementById("due").value = (calculate - payment).toFixed(2);
    // document.getElementById("member-kosten").innerHTML = ausgabe;
      }
    </script>