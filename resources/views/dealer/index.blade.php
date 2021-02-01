@extends('layouts.backend')
@section('title')
    Dealer Registration
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <a href="{{route('dealers.create')}}" class="btn btn-primary mb-2 form-control"> <i class="fa fa-plus"></i> New Costumer
            </a>
        </div>
        <div class="col-md-2">
            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                    aria-controls="filter">
                    <i class="fa fa-filter"></i> Filter
                </a>
            </p>
        </div>
        <div class="col-md-12 mb-2">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('dealers.search')}}" method="get">
                        <div class="row">   
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="name" placeholder="Name">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="address" placeholder="Address">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="phone" placeholder="Phone no.">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="pan_vat" placeholder="Pan/Vat No.">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="reg_no" placeholder="Registration No.">
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
        <div class="col-md-12 justify-content-center">
            <div class="ibox">
                <div class="ibox-head d-flex">
                    <div class="ibox-title">Dealers List</div>
                    <div class="text-right">Total Record: {{$dealers->total()}}</div>
                </div>
                <div class="ibox-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>PAN/VAT No.</th>
                                <th>Registration No.</th>
                                <th colspan="3">Action</th>
                            </tr>
                            @forelse ($dealers as $dealer)
                            <tr> 
                                <td>{{$dealer->name}}</td>
                                <td>{{$dealer->address}}</td>
                                <td>{{$dealer->phone}}</td>
                                <td>{{$dealer->email}}</td>
                                <td>{{$dealer->pan_vat}}</td>
                                <td>{{$dealer->reg_no}}</td>
                                <td>
                                    <a href="" class="text-muted"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                                <td>
                                    <a href="{{route('dealers.edit',$dealer)}}" class="text-muted"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                                <td>
                                    <form action="{{route('dealers.destroy',$dealer)}}"
                                        onsubmit="return confirm('Are you sure to delete?')" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                                class="fa fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                    <tr>
                                        <td colspan="40" class=" text-center text-danger">*Data Not Found !!!</td>
                                    </tr>
                            @endforelse
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
