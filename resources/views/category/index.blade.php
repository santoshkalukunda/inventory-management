@extends('layouts.backend')
@section('title')
Category
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Category Form</div>
            </div>
            <div class="ibox-body">
                <form action="{{$category->id ? route('categories.update',$category) : route('categories.store')}}" method="post">
                    @csrf
                    @if ($category->id)
                    @method('put')
                    @endif
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name',$category->name)}}"
                            placeholder="Category Name">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-success form-control btn-rounded">{{$category->id ? "upadete" : "Add"}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="col-md-2 px-0">
            <a class="btn btn-primary form-control" data-toggle="collapse" href="#filter" role="button"
                aria-expanded="false" aria-controls="filter">
                <i class="fa fa-filter"></i> Filter
            </a>
        </div>
        <div class="mb-2">
            <div class="collapse" id="filter">
                <div class="card card-body">
                    <form action="{{route('categories.search')}}" method="get">
                        <div class="row">
                            <div class="col-md-5 form-group">
                                <input type="text" class=" form-control" name="name" placeholder="Category">
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
                        <h3 class="m-0">Categories List</h3>
                    </div>
                    <div class="col-md text-right">
                        <span>Total Record: {{$categories->total()}}</span>
                    </div>
                </div>
                <hr>
                <table class="table table-hover">
                    <thead class="bg-dark-light">
                        <tr>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="text-muted"><i
                                        class="fa fa-edit"></i></a>
                                <span class="mx-3">|</span>
                                <form action="{{route('categories.destroy', $category) }}"
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
                {{$categories->links()}}
            </div>
        </div>
    </div>
</div>
@endsection