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
                            <th>Category Name</th>
                            <th>Category Slug</th>
                            <th>Category Photo</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $category['category_name'] }}</td>
                            <td>{{ $category['category_slug'] }}</td>
                            <td><img src="{{ asset('uploads/category_photo') }}/{{ $category['category_photo'] }}" width="80"></td>
                            <td><span class="badge light badge-success">{{ $category['created_at'] }}</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
