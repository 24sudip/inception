@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-xl-6 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Add Coupon</h4>
        </div>
        <div class="card-body">

            @if (session('cpnAdMsg'))
            <div class="alert alert-success">
                {{ session('cpnAdMsg') }}
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
                <form action="{{ route('couponAdd') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Coupon Name</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" placeholder="Coupon Name" name="coupon_name">
                        </div>
                        <label class="col-sm-3 col-form-label">Coupon Value</label>
                        <div class="col-sm-9 mb-3">
                            <select name="type" class="form-control">
                                <option value="1">Solid</option>
                                <option value="2">Percentage</option>
                            </select>
                        </div>
                        <label class="col-sm-3 col-form-label">Discount</label>
                        <div class="col-sm-9 mb-3">
                            <input type="number" class="form-control" placeholder="Discount" name="discount">
                        </div>
                        <label class="col-sm-3 col-form-label">Validity</label>
                        <div class="col-sm-9 mb-3">
                            <input type="date" class="form-control" name="coupon_date">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add Coupon</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-xl-6 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">View Coupon</h4>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-bordered">
                <thead>
                    <tr>
                        <th>Coupon Name</th>
                        <th>Coupon Type</th>
                        <th>Discount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ $coupon->type==1 ? 'Solid' : 'Percentage' }}</td>
                        <td>{{ $coupon->discount }}</td>
                        <td><strong>{{ $coupon->coupon_date }}</strong>
                        </td>
                        <td><a href="{{ route('coupon.delete', $coupon->id) }}" class="btn btn-danger btn-sm">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
