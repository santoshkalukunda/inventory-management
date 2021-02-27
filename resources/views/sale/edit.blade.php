@extends('layouts.backend')
@section('title')
Product Item Update
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Product Item Edit</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('sales.update',$sale)}}" method="post">
                    @method('put')
                    @csrf
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
                        <div class="col-md-5 form-group">
                            <label class="required">Product Name</label>
                            <select class="selectpicker form-control @error('store_id') is-invalid @enderror" name="store_id" id="quantity1"
                                data-live-search="true" data-size="3" onchange="fun1()" disabled>
                                <option value="" selected>Select Product</option>
                                @foreach ($stores as $store)
                                <option value="{{$store->id}}" data-content="<span><b>{{$store->product->name}}</b>
                                        <br>Code: {{$store->product->code}}
                                        <br>Category: {{$store->product->category->name}}
                                        <br>Brand: {{$store->product->brand->name}}
                                        <br>Model: {{$store->product->model_no}}
                                        <br>Quantity: {{$store->quantity}} {{$store->unit->name}}
                                    </span>" {{$sale->store_id == $store->id ? "selected" : '' }}>{{$store->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('store_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="quantity" class="required">Quantity</label>
                            <input type="number" min="0" step="any" class="form-control text-right @error('quantity') is-invalid @enderror"
                                name="quantity" value="{{old('quantity',$sale->quantity)}}" id="quantity" placeholder="0" onkeyup="Productfunction()">
                            @error('quantity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="unit_id1" class="required">Unit</label>
                            <select  class="form-control @error('unit_id') is-invalid @enderror" name="unit_id"   id="unit_id">
                                <option value="{{$sale->unit->id}}">{{$sale->unit->name}}</option>
                           </select>
                            @error('unit_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="rate" class="required">Rate</label>
                            <input type="number" min="0" step="any" class="form-control text-right @error('rate') is-invalid @enderror"
                                name="rate" value="{{old('rate',$sale->rate)}}" id="rate" placeholder="0" onkeyup="Productfunction()">
                            @error('rate')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="total_cost" class="required">Total Cost</label>
                            <input type="number" min="0" step="any" class="form-control text-right @error('total_cost') is-invalid @enderror"
                                name="total_cost" value="{{old('total_cost',$sale->total_cost)}}" id="total_cost" placeholder="0" onkeyup="Productfunction()" disabled>
                            @error('total_cost')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="discount">Discount in %</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('discount') is-invalid @enderror" name="discount"
                                value="{{old('discount',$sale->discount)}}" id="discount" placeholder="Discount in %"
                                onkeyup="Productfunction()">
                            @error('discount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="vat">VAT in %</label>
                            <input type="number" min="0" step="any"
                                class="form-control text-right @error('vat') is-invalid @enderror" name="vat"
                                value="{{old('vat',$sale->vat)}}" id="vat" placeholder="VAT in %" onkeyup="Productfunction()">
                            @error('vat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="total">Net-Total</label>
                            <input step="any" type="number" min="0"
                                class="form-control text-right @error('total') is-invalid @enderror" name="total"
                                value="{{old('total',$sale->total)}}" id="total" placeholder="Net-Total" readonly>
                            @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label for="" class="mb-4"></label>
                            <button type="submit" class="btn btn-success form-control btn-rounded">Save</button>
                        </div>
                    </div>
                    
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                    @foreach ($stores as $store)
                    <script>
                    $(document).ready(function () {
                        $("#quantity1").change(function () {
                            var val = $(this).val();
                            if (val == "{{$store->id}}") {
                                document.getElementById("rate").value="{{$store->mrp}}";
                                // document.getElementById("unit_id").value="{{$store->unit->name}}";
                                $("#unit_id").html("<option value='{{$store->unit->id}}'>{{$store->unit->name}}</option>");
                            } 
                        });
                    });
                    </script>
                    @endforeach
                    <script>
                        function Productfunction(){
                        var  quantity= document.getElementById("quantity").value;
                        var rate = document.getElementById("rate").value;
                        var discount = document.getElementById("discount").value;
                        var vat = document.getElementById("vat").value;
                        var calculate = (quantity * rate);
                        document.getElementById("total_cost").value = calculate.toFixed(2);
                        calculate = calculate - ((calculate * (discount)/100));
                        calculate = calculate + ((calculate * (vat)/100));
                        document.getElementById("total").value = calculate.toFixed(2);
                          }
                    </script>                    
                </form>
            </div>
        </div>
    </div>
</div>

@endsection