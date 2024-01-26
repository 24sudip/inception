@extends('layouts.dashboard.dashboardMaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>
    <div class="col-lg-12">

    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Category</h4>
            </div>
            <div class="card-body">

                @if (session('categorySuccess'))
                <div class="alert alert-success">
                    {{ session('categorySuccess') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @endif
                <div class="basic-form">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Category Name" name="category_name">
                            </div>
                            <label class="col-sm-3 col-form-label">Category Slug</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Category Slug" name="category_slug">
                            </div>
                            <label class="col-sm-3 col-form-label">Category Photo</label>
                            <div class="col-sm-9 mb-3">
                                <input type="file" class="form-control" name="category_photo"
                                onchange="document.getElementById('web').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                            <div class="col-sm-9 mb-3">
                                <img src="" id="web" style="width: 120px; height: 120px;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
