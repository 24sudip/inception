@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Product Edit</h4>
        </div>
        <div class="card-body">
            @if (session('productEditSuccess'))
            <div class="alert alert-success">
                {{ session('productEditSuccess') }}
            </div>
            @endif

            @error('product_category')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="basic-form">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Product Name</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" name="name" value="{{ $product->name }}">
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
                            <input type="number" class="form-control" value="{{ $product->purchase_price }}" name="purchase_price">
                        </div>
                        <label class="col-sm-3 col-form-label">Regular Price</label>
                        <div class="col-sm-9 mb-3">
                            <input type="number" class="form-control" value="{{ $product->regular_price }}" name="regular_price">
                        </div>
                        <label class="col-sm-3 col-form-label">Discount Price</label>
                        <div class="col-sm-9 mb-3">
                            <input type="number" class="form-control" value="{{ $product->discount_price }}" name="discount_price">
                        </div>
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" value="{{ $product->description }}" name="description">
                        </div>
                        <label class="col-sm-3 col-form-label">Long Description</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" value="{{ $product->long_description }}" name="long_description">
                        </div>
                        <label class="col-sm-3 col-form-label">Additional Information</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" value="{{ $product->additional_information }}" name="additional_information">
                        </div>
                        <label class="col-sm-3 col-form-label">Thumbnail</label>
                        <div class="col-sm-9 mb-3">
                            <input type="file" class="form-control" name="thumbnail">
                        </div>
                        <div class="col-sm-9 mb-3">
                            <img src="{{ asset('uploads/product_photo') }}/{{ $product['thumbnail'] }}" width="80">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Edit Product</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
