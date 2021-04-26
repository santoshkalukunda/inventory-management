<div class="row">
    <div class="col-md-3 form-group">
        <label for="customer_id">Customer Name</label>br
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
        <label for="bill_date_from">Bill Date From</label>
        <input type="date" class="form-control" name="bill_date_from" id="bill_date_from"
            placeholder="Bill Date From" autofocus>
    </div>
    <div class="col-md-3 form-group">
        <label for="bill_date_to">Bill Date To</label>
        <input type="date" class="form-control" name="bill_date_to" id="bill_date_to"
            placeholder="Bill Date To" autofocus>
    </div>
    <div class="col-md-3 form-group">
        <label for="status">Status Name</label>
        <select class="selectpicker form-control @error('status') is-invalid @enderror"
            name="status" id="status" data-live-search="true" data-size="4">
            <option value="" selected>Select Satus</option>
            <option value="incomplete">Incomplete</option>
            <option value="complete">Complete</option>
            <option value="cancel">Cancel</option>
        </select>
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
        <label for="total_min">Total Min.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_min') is-invalid @enderror"
            name="total_min" id="total_min" placeholder="Net-Total Min.">
    </div>
    <div class="col-md-2 form-group">
        <label for="total_max">Total Max.</label>
        <input step="any" type="number" min="0"
            class="form-control text-right @error('total_max') is-invalid @enderror"
            name="total_max" id="total_max" placeholder="Net-Total Max.">
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
        <label for="net_total_min">Net Total Min.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('net_total_min') is-invalid @enderror"
            name="net_total_min" id="net_total_min" placeholder="Net Total Min">
    </div>
    <div class="col-md-2 form-group">
        <label for="net_total_max">Net Total Max</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('net_total_max') is-invalid @enderror"
            name="net_total_max" id="net_total_max" placeholder="Net Total Max">
    </div>
    <div class="col-md-2 form-group">
        <label for="payment_min">Payment Min.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('payment_min') is-invalid @enderror"
            name="payment_min" id="payment_min" placeholder="Payment Min. Rs.">
    </div>
    <div class="col-md-2 form-group">
        <label for="payment_max">Payment Max.</label>
        <input type="number" min="0" step="any"
            class="form-control text-right @error('payment_max') is-invalid @enderror"
            name="payment_max" id="payment_max" placeholder="Payment Max. Rs.">
    </div>
    <div class="col-md-2 form-group">
        <label for="due_min">Due Min.</label>
        <input type="number" step="any"
            class="form-control text-right @error('due_min') is-invalid @enderror" name="due_min"
            id="due_min" placeholder="Due Min. Rs.">
    </div>
    <div class="col-md-2 form-group">
        <label for="due_max">Due Max.</label>
        <input type="number" step="any"
            class="form-control text-right @error('due_max') is-invalid @enderror" name="due_max"
            id="due_max" placeholder="Due Max. Rs.">
    </div>
    <div class="col-md-3 form-group">
        <label for="user_id">User Name</label>
        <select class="selectpicker form-control @error('user_id') is-invalid @enderror"
            name="user_id" id="product" data-live-search="true" data-size="4">
            <option value="" selected>Select User</option>
            @foreach ($users as $user)
            <option value="{{$user->id}}" data-content="<b>{{$user->name}}</b>"></option>
            @endforeach
        </select>
    </div>
</div>