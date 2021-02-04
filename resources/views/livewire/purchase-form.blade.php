<div>
    <form action="" method="post">
        @csrf
        @include('purchase.input')
        <div class="row">
            <div class="col-md-4 form-group">
                <label for="date" class="reauired">Date</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror"
                    value="{{old('date',$dealer->date)}}" name="date" id="date" placeholder="Date" autofocus>
                @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="bill_no" class="reauired">Bill No.</label>
                <input type="text" class="form-control @error('bill_no') is-invalid @enderror"
                    value="{{old('bill_no',$dealer->bill_no)}}" name="bill_no" id="bill_no" placeholder="Bill No."
                    autofocus>
                @error('bill_no')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="product_id" class="required">Product Name</label>
                <select class="selectpicker form-control @error('product_id') is-invalid @enderror" name="product_id"
                    id="product" data-live-search="true" data-size="5">
                    <option value="" selected>Select Product</option>
                    @foreach ($products as $product)
                    <option value="{{$product->id}}" data-subtext="{{$product->code}}"
                        {{$product->id == $dealer->product_id ? 'selected' : ''}}> {{$product->name}}</option>
                    @endforeach
                </select>
                @error('product_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="category_id" class="required">Category Name</label>
                <select class="selectpicker form-control @error('category_id') is-invalid @enderror" name="category_id"
                    id="product_id" data-live-search="true" data-size="5">
                    <option value="" selected>Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == $dealer->category_id ? 'selected' : ''}}>
                        {{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="brand_id" class="required">Brand Name</label>
                <select class="selectpicker form-control @error('brand_id') is-invalid @enderror" name="brand_id"
                    id="brand_id" data-live-search="true" data-size="5">
                    <option value="" selected>Select Brand</option>
                    @foreach ($brands as $brand)
                    <option value="{{$brand->id}}" {{$brand->id == $dealer->brand_id ? 'selected' : ''}}>
                        {{$brand->name}}</option>
                    @endforeach
                </select>
                @error('brand_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="model_no">Model No.</label>
                <input type="text" class="form-control @error('model_no') is-invalid @enderror" name="model_no"
                    value="{{old('model_no',$dealer->model_no)}}" id="model_no" placeholder="Model No.">
                @error('model_no')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="batch_no">Batch No.</label>
                <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no"
                    value="{{old('batch_no',$dealer->batch_no)}}" id="batch_no" placeholder="Batch No.">
                @error('batch_no')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="mf_date">Manufacture Date</label>
                <input type="date" class="form-control @error('mf_date') is-invalid @enderror" name="mf_date"
                    value="{{old('mf_date',$dealer->mf_date)}}" id="mf_date" placeholder="Batch No.">
                @error('mf_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-4 form-group">
                <label for="exp_date">Expiry Date</label>
                <input type="date" class="form-control @error('exp_date') is-invalid @enderror" name="exp_date"
                    value="{{old('exp_date',$dealer->exp_date)}}" id="exp_date" placeholder="Batch No.">
                @error('exp_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="quantity" class="required">Quantity</label>
                <input wire:model="quantity" type="number" min="0" class="form-control @error('quantity') is-invalid @enderror"
                    name="quantity" value="{{old('quantity',$dealer->quantity)}}" id="quantity" placeholder="Quantity">
                @error('quantity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="unit_id" class="required">Unit</label>
                <select wire:model="purchase.unit_id" class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id"
                    id="unit_id" data-live-search="true" data-size="5">
                    <option value="" selected>Select Unit</option>
                    @foreach ($units as $unit)
                    <option value="{{$unit->id}}" {{$unit->id == $dealer->unit_id ? 'selected' : ''}}> {{$unit->name}}
                    </option>
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
                <input wire:model="rate" type="number" min="0" class="form-control @error('rate') is-invalid @enderror" name="rate"
                    value="{{old('rate',$dealer->rate)}}" id="rate" placeholder="Rate Rs.">
                @error('rate')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="discount">Discount in %</label>
                <input type="number" min="0" class="form-control @error('discount') is-invalid @enderror"
                    name="discount" value="{{old('discount',$dealer->discount)}}" id="discount"
                    placeholder="Discount in %">
                @error('discount')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="vat">VAT in %</label>
                <input wire:model.defer="purchase.vat" type="number" min="0" class="form-control @error('vat') is-invalid @enderror" name="vat"
                    value="{{old('vat',$dealer->vat)}}" id="vat" placeholder="VAT in %">
                @error('vat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="total">Total</label>
                <input wire:model="total" type="number" min="0" class="form-control @error('total') is-invalid @enderror" name="total"
                    value="{{old('total',$dealer->total)}}" id="total" placeholder="Total" readonly>
                @error('total')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="due">Due Amount</label>
                <input type="number" min="0" class="form-control @error('due') is-invalid @enderror" name="due"
                    value="{{old('due',$dealer->due)}}" id="due" placeholder="Due Amount" readonly>
                @error('due')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="payment">Payment Amount</label>
                <input type="number" min="0" class="form-control @error('payment') is-invalid @enderror" name="payment"
                    value="{{old('payment',$dealer->payment)}}" id="payment" placeholder="Payment Amount">
                @error('payment')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-2 form-group">
                <label for="mrp">MRP</label>
                <input type="number" min="0" class="form-control @error('mrp') is-invalid @enderror" name="mrp"
                    value="{{old('mrp',$dealer->mrp)}}" id="mrp" placeholder="MRP">
                @error('mrp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="details">Other details</label>
                <textarea type="text" id="details" name="details"
                    class="form-control  @error('details') is-invalid @enderror" rows="2"
                    placeholder="Details...">{{old('details',$dealer->details)}}</textarea>
                @error('details')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-2">
                <a href="{{route('dealers.index')}}" class="btn btn-danger form-control btn-rounded">Back</a>
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-success form-control btn-rounded">Save</button>
            </div>
        </div>

    </form>
</div>