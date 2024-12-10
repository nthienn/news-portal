@extends('admin.layouts.master')

@section('title', __('admin.Profile'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Profile') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Profile') }}</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">{{ __('admin.Hi') }}, {{ $user->name }}!</h2>
            <p class="section-lead">
                {{ __('admin.Change information about yourself on this page') }}
            </p>

            <div class="row mt-sm-4">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <form method="POST"
                            action="{{ route('admin.profile.update', auth()->guard('admin')->user()->id) }}"
                            class="needs-validation" novalidate="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>{{ __('admin.Edit Profile') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
                                        <input type="file" name="image" id="image-upload" />
                                        <input type="hidden" name="old_image" value="{{ $user->image }}" />
                                    </div>
                                    @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Name') }}</label>
                                    <input type="text" value="{{ $user->name }}" name="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Email') }}</label>
                                    <input type="email" value="{{ $user->email }}" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('admin.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <form method="post"
                            action="{{ route('admin.update-password', auth()->guard('admin')->user()->id) }}"
                            class="needs-validation" novalidate="">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>{{ __('admin.Update Password') }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Current Password') }}</label>
                                    <input type="password" name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('admin.New Password') }}</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('admin.Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror">
                                    @error('password_confirmation')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">{{ __('admin.Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($user->image) }})',
                "background-size": 'cover',
                'background-position': 'center center'
            });
        });
    </script>
@endpush
