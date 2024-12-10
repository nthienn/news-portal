@extends('frontend.layouts.master')

@section('content')
    <!-- login -->
    <section class="wrap__section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mx-auto" style="max-width: 380px;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">{{ __('frontend.Sign In') }}</h4>
                            <!-- Session Status -->
                            @if (session()->has('status'))
                                <div class="alert alert-success">{{ session()->get('status') }}</div>
                            @endif
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="{{ __('frontend.Email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="{{ __('frontend.Password') }}"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <a href="{{ route('password.request') }}" class="float-right">
                                        {{ __('frontend.Forgot password?') }}
                                    </a>
                                    <label class="float-left custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember">
                                        <span class="custom-control-label">{{ __('frontend.Remember me') }}</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('frontend.Login') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <p class="text-center mt-4 mb-0">{{ __("frontend.Don't have account?") }}
                        <a href="{{ route('register') }}">{{ __('frontend.Sign Up') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end login -->
@endsection
