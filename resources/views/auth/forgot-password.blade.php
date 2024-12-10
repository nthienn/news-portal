@extends('frontend.layouts.master')

@section('content')
    <!-- forgot password -->
    <section class="wrap__section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mx-auto" style="max-width: 380px;">
                        <div class="card-body">
                            <p class="text-muted">
                                {{ __('frontend.Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </p>
                            <!-- Session Status -->
                            @if (session()->has('status'))
                                <div class="alert alert-success">{{ session()->get('status') }}</div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
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
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('frontend.Email Password Reset Link') }}</button>
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
    <!-- end forgot password -->
@endsection
