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
                        <label class="col-sm-3 col-form-label">Coupon Percentage</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" placeholder="Coupon Percentage" name="coupon_percentage">
                        </div>
                        <label class="col-sm-3 col-form-label">Coupon Fixed</label>
                        <div class="col-sm-9 mb-3">
                            <input type="text" class="form-control" placeholder="Coupon Fixed" name="coupon_fixed">
                        </div>
                        <label class="col-sm-3 col-form-label">Coupon Date</label>
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
@endsection
