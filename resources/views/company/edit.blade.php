@extends('layouts.backend')
@section('title')
Company Profile
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Company Profile</div>
            </div>
            <div class="ibox-body">
                <form action="{{route('companies.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="name" class="required">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{old('name',$company->name)}}" name="name" id="name" placeholder="Name"
                                autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="address" class="required">address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" value="{{old('address',$company->address)}}" id="address"
                                placeholder="Address">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="contact" class="required">Contact</label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror"
                                name="contact" value="{{old('contact',$company->contact)}}" id="contact"
                                placeholder="Contact">
                            @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{old('email',$company->email)}}" id="email" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="website">Website</label>
                            <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                                value="{{old('website',$company->website)}}" id="website" placeholder="Website">
                            @error('website')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="type">PAN/VAT</label>
                            <select type="text" class="form-control @error('type') is-invalid @enderror"
                                name="type" id="type">
                                <option value="PAN">PAN</option>
                                <option value="VAT" {{$company->pan_vat == 'VAT' ? 'selected' : ''}}>VAT</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-2 form-group">
                            <label for="pan_vat">PAN/VAT No.</label>
                            <input type="text" class="form-control @error('pan_vat') is-invalid @enderror"
                                name="pan_vat" value="{{old('pan_vat',$company->pan_vat)}}" id="pan_vat"
                                placeholder="PAN/VAT No.">
                            @error('pan_vat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-success form-control btn-rounded">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection