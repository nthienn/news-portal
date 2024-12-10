@extends('admin.layouts.master')

@section('title', __('admin.Edit Role User'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Edit Role User') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.role.index') }}">{{ __('admin.Role User') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Edit') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Edit Role User') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.role-user.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('admin.User Name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ $user->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ $user->email }}">
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Password') }}</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Role') }}</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">--- {{ __('admin.Select') }} ---</option>
                                @foreach ($roles as $role)
                                    <option @if ($role->name === $user->getRoleNames()->first()) selected @endif value="{{ $role->name }}">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
