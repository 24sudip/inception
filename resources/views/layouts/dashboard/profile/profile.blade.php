@extends('layouts.dashboard.dashboardMaster')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>
    <div class="col-lg-12">
        <div class="profile card card-body px-3 pt-3 pb-0">
            <div class="profile-head">
                <div class="photo-content">
                    <div class="cover-photo"></div>
                </div>
                <div class="profile-info">
                    <div class="profile-photo">
                        @if ('auth()->user->profile_photo')
                        <img src="{{ asset('uploads/profile_photos') }}/{{ auth()->user()->profile_photo }}"
                        class="img-fluid rounded-circle" alt="">
                        @else
                        <img src="{{ asset('dashboard_assets') }}/images/profile/profile.png" class="img-fluid rounded-circle" alt="">
                        @endif
                    </div>
                    <div class="profile-details">
                        <div class="profile-name px-3 pt-2">
                            <h4 class="text-primary mb-0">{{ auth()->user()->name }}</h4>
                            <p>UX / UI Designer</p>
                        </div>
                        <div class="profile-email px-2 pt-2">
                            <h4 class="text-muted mb-0">{{ auth()->user()->email }}</h4>
                            <p>Email</p>
                        </div>
                        <div class="dropdown ml-auto">
                            <a href="#" class="btn btn-primary light sharp" data-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li class="dropdown-item"><i class="fa fa-user-circle text-primary mr-2"></i> View profile</li>
                                <li class="dropdown-item"><i class="fa fa-users text-primary mr-2"></i> Add to close friends</li>
                                <li class="dropdown-item"><i class="fa fa-plus text-primary mr-2"></i> Add to group</li>
                                <li class="dropdown-item"><i class="fa fa-ban text-primary mr-2"></i> Block</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Password Change</h4>
            </div>
            <div class="card-body">
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

                @if (session('passChngSuccess'))
                <div class="alert alert-success">
                    {{ session('passChngSuccess') }}
                </div>
                @endif
                <div class="basic-form">
                    <form action="{{ url('/password/change') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Old Password</label>
                            <div class="col-sm-9 mb-3">
                                <input type="password" class="form-control" placeholder="Password Old" name="old_password">
                            </div>
                            <label class="col-sm-3 col-form-label">New Password</label>
                            <div class="col-sm-9 mb-3">
                                <input type="password" class="form-control" placeholder="Password New" name="password">
                            </div>
                            <label class="col-sm-3 col-form-label">Conform Password</label>
                            <div class="col-sm-9 mb-3">
                                <input type="password" class="form-control" placeholder="Password Conform" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Password Change</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12">
        <div class="card">
            @if (session('photoSuccess'))
            <div class="alert alert-success">
                {{ session('photoSuccess') }}
            </div>
            @endif

            @error('profile_photo')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="card-header">
                <h4 class="card-title">Profile Photo Upload</h4>
            </div>
            <div class="card-body">
                <div class="basic-form custom_file_input">
                    <form action="{{ url('/profile/photo/upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="profile_photo">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Profile Photo Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
