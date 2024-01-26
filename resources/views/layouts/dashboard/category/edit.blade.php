@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Category Edit</h4>
        </div>
        <div class="card-body">
            @if (session('categoryEditSuccess'))
            <div class="alert alert-success">
                {{ session('categoryEditSuccess') }}
            </div>
            @endif

            {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
            @endif --}}
            <div class="basic-form">
                <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Category Name</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" name="category_name"
                            value="{{ $category->category_name }}">
                        </div>
                        <label class="col-sm-3 col-form-label">Category Slug</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" name="category_slug"
                            value="{{ $category->category_slug }}">
                        </div>
                        <label class="col-sm-3 col-form-label">Category Photo</label>
                        <div class="col-sm-9 mb-3">
                            <input type="file" class="form-control" name="category_photo">
                        </div>
                        <div class="col-sm-9 mb-3">
                            <img src="{{ asset('uploads/category_photo') }}/{{ $category['category_photo'] }}" width="80">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Edit Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
