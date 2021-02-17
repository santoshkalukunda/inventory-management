
<div class="col-md-12 mb-2">
    <div class="collapse" id="filter">
        <div class="card card-body">
            <form action="{{route('purchase.search')}}" method="get">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="dealer_id">Dealer Name</label>br
                        <select class="selectpicker form-control @error('dealer_id') is-invalid @enderror"
                            name="dealer_id" id="product" data-live-search="true" data-size="4">
                            <option value="" selected>Select Dealer</option>
                            @foreach ($dealers as $dealer)
                            <option value="{{$dealer->id}}"data-content="<b>{{$dealer->name}}</b>
                                <br>{{$dealer->address}}
                                <br>{{$dealer->pan_vat}}
                                "></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="bill_no">Bill No.</label>
                        <input type="number" min="0" class="form-control @error('bill_no') is-invalid @enderror"
                            name="bill_no" id="bill_no" placeholder="Bill No." autofocus>

                    </div>
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
                                <br>{{$product->serial_no}}
                            </span>">    
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="batch_no">Batch No.</label>
                        <input type="text" class="form-control @error('batch_no') is-invalid @enderror" name="batch_no"
                            id="batch_no" placeholder="Batch No.">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="order_date_from">Order Date From</label>
                        <input type="date" class="form-control" name="order_date_from" id="order_date_from"
                            placeholder="Order Date From" autofocus>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="order_date_to">Order Date To</label>
                        <input type="date" class="form-control" name="order_date_to" id="order_date_to"
                            placeholder="Order Date" autofocus>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="shipping_date_from">Shipping Date From</label>
                        <input type="date" class="form-control @error('shipping_date_from') is-invalid @enderror"
                            name="shipping_date_from" id="shipping_date_from" placeholder="Shipping Date">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="shpping_date">Shipping Date To</label>
                        <input type="date" class="form-control @error('shipping_date_to') is-invalid @enderror"
                            name="shipping_date_to" id="shipping_date_to" placeholder="Shipping Date">
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
                        <select class="selectpicker form-control @error('unit_id') is-invalid @enderror" name="unit_id"
                            id="unit_id" data-live-search="true" data-size="5">
                            <option value="" selected>Select Unit</option>
                            @foreach ($units as $unit)
                            <option value="{{$unit->id}}">
                                {{$unit->name}}</option>
                            @endforeach
                        </select>

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

                    </div>
                    <div class="col-md-2 form-group">
                        <label for="discount_min">Discount Min. in %</label>
                        <input type="number" Min="0" step="any"
                            class="form-control text-right @error('discount_min') is-invalid @enderror"
                            name="discount_min" id="discount_min" placeholder="Discount Min.">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="discount_max">Discount Max. in%</label>
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
                            class="form-control text-right @error('total_min') is-invalid @enderror" name="total_min"
                            id="total_min" placeholder="Net-Total Min.">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="total_max">Net Total Max.</label>
                        <input step="any" type="number" min="0"
                            class="form-control text-right @error('total_max') is-invalid @enderror" name="total_max"
                            id="total_max" placeholder="Net-Total Max.">
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
                    <div class="col-md-2 form-group">
                        <label for="mrp_min">MRP Min.</label>
                        <input type="number" min="0"
                            class="form-control text-right @error('mrp_min') is-invalid @enderror" name="mrp_min"
                            id="mrp_min" placeholder="MRP Min.">
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="mrp_max">MRP Max.</label>
                        <input type="number" min="0"
                            class="form-control text-right @error('mrp_max') is-invalid @enderror" name="mrp_max"
                            id="mrp_max" placeholder="MRP Max.">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input type="submit" class="form-control btn- btn-primary" value="Search">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
