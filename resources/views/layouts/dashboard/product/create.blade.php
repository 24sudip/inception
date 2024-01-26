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
    <div class="col-xl-8 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Product</h4>
            </div>
            <div class="card-body">

                @if (session('productAddMsg'))
                <div class="alert alert-success">
                    {{ session('productAddMsg') }}
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
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Product Name</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Name" name="name">
                            </div>
                            <label class="col-sm-3 col-form-label">Product Category</label>
                            <div class="col-sm-9 mb-3">
                                <select class="form-control" name="product_category">
                                    <option value="">Select One Category</option>
                                    @foreach($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-3 col-form-label">Purchase Price</label>
                            <div class="col-sm-9 mb-3">
                                <input type="number" class="form-control" placeholder="Purchase Price" name="purchase_price">
                            </div>
                            <label class="col-sm-3 col-form-label">Regular Price</label>
                            <div class="col-sm-9 mb-3">
                                <input type="number" class="form-control" placeholder="Regular Price" name="regular_price">
                            </div>
                            <label class="col-sm-3 col-form-label">Discount Price</label>
                            <div class="col-sm-9 mb-3">
                                <input type="number" class="form-control" placeholder="Discount Price" name="discount_price">
                            </div>
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Description" name="description">
                            </div>
                            <label class="col-sm-3 col-form-label">Long Description</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Long Description" name="long_description">
                            </div>
                            <label class="col-sm-3 col-form-label">Additional Information</label>
                            <div class="col-sm-9 mb-3">
                                <input type="text" class="form-control" placeholder="Additional Information" name="additional_information">
                            </div>
                            <label class="col-sm-3 col-form-label">Thumbnail</label>
                            <div class="col-sm-9 mb-3">
                                <input type="file" class="form-control" name="thumbnail">
                            </div>
                            <label class="col-sm-3 col-form-label">Product Gallery</label>
                            <div class="col-sm-9 mb-3">
                                <input multiple type="file" class="form-control" name="product_galleries[]">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
