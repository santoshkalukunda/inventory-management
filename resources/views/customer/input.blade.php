<div class="row">
    <div class="col-md-4 form-group">
        <label for="name" class="reauired">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name',$customer->name)}}" name="name" id="name" placeholder="Name" autofocus>
        @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="address" class="required">address</label>
        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{old('address',$customer->address)}}" id="address" placeholder="Address">
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="phone" class="required">Phone</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone',$customer->phone)}}" id="phone" placeholder="Phone">
        @error('phone')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email',$customer->email)}}" id="email" placeholder="Email">
        @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="col-md-4 form-group">
        <label for="pan_vat">PAN/VAT No.</label>
        <input type="text" class="form-control @error('pan_vat') is-invalid @enderror" name="pan_vat" value="{{old('pan_vat',$customer->pan_vat)}}" id="pan_vat" placeholder="PAN/VAT No.">
        @error('pan_vat')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-12">
        <label for="details">Other details</label>
        <textarea type="text" id="details" name="details"
            class="form-control  @error('details') is-invalid @enderror"
        rows="2" placeholder="Details...">{{old('details',$customer->details)}}</textarea>
        @error('details')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="form-group col-md-2" >
        <a href="{{route('customers.index')}}" class="btn btn-danger form-control btn-rounded">Back</a>
    </div>
    <div class="form-group col-md-2" >
        <button type="submit" class="btn btn-success form-control btn-rounded">Save</button>
    </div>
</div>