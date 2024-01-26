@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Recent Payments Queue</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-md table-bordered">
                    <thead>
                        <tr>
                            <th class="width80">SL</th>
                            <th>Product Name</th>
                            <th>Product Category</th>
                            <th>Product Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td><strong>{{ $product['id'] }}</strong></td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product->relationWithProductToCategory->category_name }}</td>
                            <td><img src="{{ asset('uploads/product_photo') }}/{{ $product['thumbnail'] }}" width="80"></td>
                            <td>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    <a href="{{ route('product.inventory', $product->id) }}" class="btn btn-info btn-sm">Inventory</a>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td>Category Not Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
