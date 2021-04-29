@extends('layouts.backend')
@section('title')
Customer List
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="mb-1 d-flex">
            <div class="mr-2">
                <a href="{{route('register')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Register</a>
            </div>
            <div>
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                        aria-controls="filter">
                        <i class="fa fa-filter"></i> Filter
                    </a>
                </p>
            </div>
        </div>
        <div class="mb-2">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('users.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="name" placeholder="Name">
                            </div>
                            <div class="col-md-3 form-group">
                                <input type="text" class=" form-control" name="email" placeholder="Email">
                            </div>
                            <div class="col-md-2 form-group">
                                <select name="role" id="" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" class=" text-capitalize">
                                        {{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 justify-content-center">
        <div class="ibox">
            <div class="ibox-head d-flex">
                <div class="ibox-title">Users List</div>
                <div class="text-right">Total Record: {{$users->total()}}</div>
            </div>
            <div class="ibox-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th colspan="4">Action</th>
                        </tr>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @foreach($user->roles as $role)
                                {{ $role->name }}
                                @if(!$loop->last)| @endif
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('users.changePasswordShow', $user) }}" class="btn-success btn" class="fa fa-trash-alt btn btn-danger" data-toggle="tooltip" data-placement="top" title="change password"><i
                                        class="fa fa-key"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user) }}" class="fa fa-edit btn btn-primary"
                                    data-toggle="tooltip" data-placement="top" title="delete"></a>
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
        {{$users->links()}}
    </div>
</div>

@endsection