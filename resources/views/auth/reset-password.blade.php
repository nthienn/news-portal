@extends('frontend.layouts.master')

@section('content')
    <!-- reset password -->
    <section class="wrap__section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mx-auto" style="max-width: 380px;">
                        <div class="card-body">
                            <h4 class="card-title mb-4">{{ __('frontend.Reset Password') }}</h4>
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="{{ __('frontend.Email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('emaill', $request->email) }}">
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
                                    <input type="password" name="password_confirmation"
                                        placeholder="{{ __('frontend.Confirm Password') }}"
                                        class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('frontend.Reset Password') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <p class="text-center mt-4 mb-0">{{ __('frontend.Already have account?') }}
                        <a href="{{ route('login') }}">{{ __('frontend.Sign In') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end reset password -->
@endsection
