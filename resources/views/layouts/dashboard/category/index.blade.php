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
                            <th>Category Name</th>
                            <th>Category Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorys as $category)
                        <tr>
                            <td><strong>{{ $category['id'] }}</strong></td>
                            <td>{{ $category['category_name'] }}</td>
                            <td><a href="{{ route('category.show', $category->id) }}" class="btn btn-info btn-sm">Details</a></td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
