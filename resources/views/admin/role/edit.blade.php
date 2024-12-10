@extends('admin.layouts.master')

@section('title', __('admin.Edit Role'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Edit Role') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.role.index') }}">{{ __('admin.Role') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Edit') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Edit Role') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.role.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('admin.Role Name') }}</label>
                            <input type="text" name="role" class="form-control @error('role') is-invalid @enderror"
                                value="{{ $role->name }}">
                            @error('role')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach ($permissions as $groupName => $permission)
                            <div class="form-group">
                                <h6 class="text-primary">{{ $groupName }}</h6>
                                <div class="row">
                                    @foreach ($permission as $value)
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="custom-switch mt-2">
                                                    <input type="checkbox" class="custom-switch-input"
                                                        value="{{ $value->name }}" name="permissions[]"
                                                        @if (in_array($value->name, $rolesPermissions)) checked @endif>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">{{ $value->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
