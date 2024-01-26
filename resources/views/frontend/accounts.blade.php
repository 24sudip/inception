@extends('frontend.frontendMaster')

@section('content')
<!-- register_section - start
            ================================================== -->
            <section class="register_section section_space">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">

                            <ul class="nav register_tabnav ul_li_center" role="tablist">
                                <li role="presentation">
                                    <button data-bs-toggle="tab" data-bs-target="#signin_tab" type="button" role="tab" aria-controls="signin_tab" aria-selected="true">Sign In</button>
                                </li>
                                <li role="presentation">
                                    <button class="active" data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab" aria-controls="signup_tab" aria-selected="false">Register</button>
                                </li>
                            </ul>

                            <div class="register_wrap tab-content">
                                <div class="tab-pane fade" id="signin_tab" role="tabpanel">
                                    <form action="{{ route('customerLogin') }}" method="POST">
                                        @csrf
                                        <div class="form_item_wrap">
                                            <h3 class="input_title">email</h3>
                                            <div class="form_item">
                                                <label for="username_input"><i class="fas fa-user"></i></label>
                                                <input id="username_input" type="email" name="email" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Password*</h3>
                                            <div class="form_item">
                                                <label for="password_input"><i class="fas fa-lock"></i></label>
                                                <input id="password_input" type="password" name="password" placeholder="Password">
                                            </div>
                                            <div class="checkbox_item">
                                                <input id="remember_checkbox" type="checkbox">
                                                <label for="remember_checkbox">Remember Me</label>
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <button type="submit" class="btn btn_primary">Sign In</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade show active" id="signup_tab" role="tabpanel">
                                    <form action="{{ route('customerRegistration') }}" method="POST">
                                        @csrf
                                        @if (session('registerSuccess'))
                                        <div class="alert alert-success">
                                            {{ session('registerSuccess') }}
                                        </div>
                                        @endif
                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Name*</h3>
                                            <div class="form_item">
                                                <label for="username_input2"><i class="fas fa-user"></i></label>
                                                <input id="username_input2" type="text" name="name" placeholder="Name">
                                            </div>
                                        </div>
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Email*</h3>
                                            <div class="form_item">
                                                <label for="email_input"><i class="fas fa-envelope"></i></label>
                                                <input id="email_input" type="email" name="email" placeholder="Email">
                                            </div>
                                        </div>
                                        @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Password*</h3>
                                            <div class="form_item">
                                                <label for="password_input2"><i class="fas fa-lock"></i></label>
                                                <input id="password_input2" type="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form_item_wrap">
                                            <h3 class="input_title">Confirm Password*</h3>
                                            <div class="form_item">
                                                <label for="password_input2"><i class="fas fa-lock"></i></label>
                                                <input id="password_input2" type="password" name="password_confirmation"
                                                placeholder="Confirm Password">
                                            </div>
                                        </div>
                                        @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form_item_wrap">
                                            <div class="form_item">
                                                {!! NoCaptcha::display() !!}
                                            </div>
                                        </div>

                                        <div class="form_item_wrap">
                                            <button type="submit" class="btn btn_secondary">Register</button>
                                        </div>
                                    </form>
                                    <div class="form_item_wrap mt-4">
                                        <a href="{{ route('githubRedirect') }}" class="btn btn_secondary">github</a>
                                    </div>
                                    <div class="form_item_wrap mt-4">
                                        <a href="{{ url('/password/reset') }}" class="btn btn_secondary">Forget Password? Click Here
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- register_section - end
            ================================================== -->
@endsection
