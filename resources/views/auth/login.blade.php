@extends('auth.layouts.master')
@section('title', 'Login')
@section('content')
    <div class="row h-50">
        <div class="col-lg-5 col-12">
            <div id="auth-left" >
                <div class="auth-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('uploads/' . $data['app_logo']) }}" alt="Logo"></a>
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-3">Log in with your data that you entered during registration.</p>
                @if (Session::has('failed'))
                    <span class="text-danger">{{ session('failed') }}</span>
                @endif
                <form id="loginForm" class="mb-3" action="{{ route('login') }}" method="POST"
                    enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control form-control-xl" id="username" name="username"
                            placeholder="Enter your username" data-parsley-required="true" autofocus />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control form-control-xl" placeholder="Password" name="password"
                            data-parsley-required="true" required>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    {{-- <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label text-gray-600" for="flexCheckDefault">
                        Keep me logged in
                    </label>
                </div> --}}
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3 g-recaptcha" type="submit"
                        data-sitekey="{{ config('services.recaptcha.site_key') }}" data-callback='onSubmit'
                        data-action='signIn'>Log in</button>
                    {!! RecaptchaV3::field('login') !!}
                </form>
                {{-- <div class="text-center mt-5 text-lg fs-4">
                <p class="text-gray-600">Don't have an account? <a href="auth-register.html" class="font-bold">Sign
                        up</a>.</p>
                <p><a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>.</p>
            </div> --}}
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-flex" style="position: relative;height:100vh;">
            
            <div class="background-image"></div>
            <div class="background-shadow"></div>
            <div class="d-flex flex-column py-10 py-lg-15 px-5 px-md-15 w-100"
                style="justify-content: space-between;z-index:2">
                <div class="flex flex-column flex-center" style="align-items: center;display:flex;padding-top:20%;">
                    <h1 class="text-white fw-bolder text-center fs-1 fs-lg-2qx">{{ $data['app_name'] }}</h1>
                    <p class="auth-subtitle text-white">{{ $data['app_description'] }}</p>
                </div>
            </div>
            {{-- <div id="auth-right">
                <div class="text-center pt-10" style="z-index:2;">
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@push('after-style')
    <style>
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('custom/assets/compiled/png/auth-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: 0;
        }

        .background-shadow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
        }
    </style>
@endpush
