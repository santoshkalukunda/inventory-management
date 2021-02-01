@extends('layouts.backend')
@section('title')
Dashbord
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Unit Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{$unit->id ? route('units.update',$unit) : route('units.store')}}" method="post">
                    @csrf
                    @if ($unit->id)
                    @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name',$unit->name)}}"
                            placeholder="Unit Name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-success form-control btn-rounded">{{$unit->id ? "upadete" : "Add"}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="mb-2">
            <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button"
                    aria-expanded="false" aria-controls="filter">
                    <i class="fa fa-filter"></i> Filter
                </a>
            </p>
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('units.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <input type="text" class=" form-control" name="name" placeholder="Unit">
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="form-control btn- btn-primary" value="Search">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-body table-responsive">
                <div class="row">
                    <div class="col-md">
                        <h3 class="m-0">Units List</h3>
                    </div>
                    <div class="col-md text-right">
                        <span>Total Record: {{$units->total()}}</span>
                    </div>
                </div>
                <hr>
                <table class="table table-hover">
                    <thead class="bg-dark-light">
                        <tr>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                        <tr>
                            <td>{{$unit->name}}</td>
                            <td>
                                <a href="{{ route('units.edit', $unit) }}" class="text-muted"><i
                                        class="fa fa-edit"></i></a>
                                <span class="mx-3">|</span>
                                <form action="{{route('units.destroy', $unit) }}"
                                    onsubmit="return confirm('Are you sure to delete?')" method="POST" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="border-0 my-0 p-0 text-danger bg-transparent"><i
                                            class="fa fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10"><span class="text-danger">*No data list Found</span></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$units->links()}}
            </div>
        </div>
    </div>
</div>
@endsection