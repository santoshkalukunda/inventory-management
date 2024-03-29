<div class="row">
    <div class="col-md-3 form-group">
        <label for="customer_id">Customer Name</label>
        <select class="selectpicker form-control @error('customer_id') is-invalid @enderror"
            name="customer_id" id="product" data-live-search="true" data-size="4">
            <option value="" selected>Select Customer</option>
            @foreach ($customers as $customer)
            <option value="{{$customer->id}}" data-content="<b>{{$customer->name}}</b>
                <br>{{$customer->address}}
                <br>{{$customer->phone}}
                <br>{{$customer->pan_vat}}
                "></option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 form-group">
        <label for="store_id">Product</label>
        <select class="selectpicker form-control @error('store_id') is-invalid @enderror"
            name="store_id" id="store_id" data-live-search="true" data-size="3">
            <option value="" selected>Select Product</option>
            @foreach ($stores as $store)
            <option value="{{$store->id}}" data-content="<b>{{$store->product->name}}</b>
                <br>{{$store->product->code}}
                <br>{{$store->product->brand->name}}
                <br>{{$store->product->category->name}}
                @if($store->product->model_no)
                <br>{{$store->product->model_no}}
                @endif
                @if($store->batch_no)
                <br><b>Batch </b> {{$store->batch_no}}
                @endif
                @if($store->mf_date)
                <br> <b>mf. </b>{{$store->mf_date}}
                @endif
                @if($store->exp_date)
                <br> <b>Exp. </b> {{$store->exp_date}}
                @endif
                "></option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 form-group">
        <label for="bill_date_from">Bill Date From</label>
        <input type="date" class="form-control" name="bill_date_from" id="bill_date_from"
            placeholder="Bill Date From" autofocus>
    </div>
    <div class="col-md-3 form-group">
        <label for="bill_date_to">Bill Date To</label>
        <input type="date" class="form-control" name="bill_date_to" id="bill_date_to"
            placeholder="Bill Date To" autofocus>
    </div>
    <div class="col-md-2 form-group">
        <label for="invoice_no_min">Invoice No. Min.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('invoice_no_min') is-invalid @enderror"
            name="invoice_no_min" id="invoice_no_min" placeholder="Invoice No. Min">
    </div>
    <div class="col-md-2 form-group">
        <label for="invoice_no_max">Invoice No Max</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('invoice_no_max') is-invalid @enderror"
            name="invoice_no_max" id="invoice_no_max" placeholder="Invoice No. Max">
    </div>
    <div class="col-md-2 form-group">
        <label for="quantity_min">Quantity Min</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('quantity_min') is-invalid @enderror"
            name="quantity_min" id="quantity_min" placeholder="Quantity Min">
    </div>
    <div class="col-md-2 form-group">
        <label for="quantity_max">Quantity Max</label>
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
    </div>
    <div class="col-md-2 form-group">
        <label for="rate_min">Rate Min.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('rate_min') is-invalid @enderror" name="rate_min"
            id="rate_min" placeholder="Rate Min. Rs.">
    </div>
    <div class="col-md-2 form-group">
        <label for="rate_max">Rate Max.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('rate_max') is-invalid @enderror" name="rate_max"
            id="rate_max" placeholder="Rate Max. Rs.">
    </div>
    <div class="col-md-2 form-group">
        <label for="total_cost_min">Total Min.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_cost_min') is-invalid @enderror"
            name="total_cost_min" id="total_cost_min" placeholder="total Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="total_cost_max">Net total_cost Max.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_cost_max') is-invalid @enderror"
            name="total_cost_max" id="total_cost_max" placeholder="total Max.">
    </div>
    <div class="col-md-2 form-group">
        <label for="pdiscount_in" class="required">Discoutn in </label>
        <select class="form-control" name="discount_in"
            id="pdiscount_in" >
            <option value="" >Select In</option>
            <option value="percent">Percent</option>
            <option value="fixed">Fixed</option>
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label for="discount_min">Discount Min.</label>
        <input type="number" Min="0" step="any"
            class="form-control text-right @error('discount_min') is-invalid @enderror"
            name="discount_min" id="discount_min" placeholder="Discount Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="discount_max">Discount Max.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('discount_max') is-invalid @enderror"
            name="discount_max" id="discount_max" placeholder="Discount Max in %">
    </div>
    <div class="col-md-2 form-group">
        <label for="vat_min">TAX/VAT Min. in%</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('vat_min') is-invalid @enderror" name="vat_min"
            id="vat_min" placeholder="TAX/VAT Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="vat_max">TAX/VAT Max. in %</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('vat_max') is-invalid @enderror" name="vat_max"
            id="vat_max" placeholder="TAX/VAT Max.">
    </div>
    <div class="col-md-2 form-group">
        <label for="total_min">Net Total Min.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_min') is-invalid @enderror"
            name="total_min" id="total_min" placeholder="Net-Total Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="total_max">Net Total Max.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_max') is-invalid @enderror"
            name="total_max" id="total_max" placeholder="Net-Total Max.">
    </div>
</div>