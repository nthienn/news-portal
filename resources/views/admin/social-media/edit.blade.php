@extends('admin.layouts.master')

@section('title', __('admin.Edit Social Media'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Edit Social Media') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.social-media.index') }}">{{ __('admin.Social Media') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Edit') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Edit Social Media') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.social-media.update', $social) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('admin.Name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ $social->name }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('admin.Icon') }}</label>
                            <br>
                            <button class="btn btn-primary" name="icon" role="iconpicker"
                                data-icon="{{ $social->icon }}"></button>
                            @error('icon')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Background Color') }}</label>
                            <div class="input-group colorpickerinput">
                                <input type="text" name="background_color" value="{{ $social->background_color }}"
                                    class="form-control @error('background_color') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="fas fa-fill-drip"></i>
                                    </div>
                                </div>
                                @error('background_color')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Url') }}</label>
                            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror"
                                value="{{ $social->url }}">
                            @error('url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Status') }}</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option @if ($social->status === 1) selected @endif value="1">
                                    {{ __('admin.Active') }}
                                </option>
                                <option @if ($social->status === 0) selected @endif value="0">
                                    {{ __('admin.Inactive') }}
                                </option>
                            </select>
                            @error('status')
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

@push('scripts')
    <script>
        $('.colorpickerinput').colorpicker({
            format: 'hex',
            component: '.input-group-append'
        })
    </script>
@endpush
