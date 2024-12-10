@extends('admin.layouts.master')

@section('title', __('admin.Edit Category'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Edit Category') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.category.index') }}">{{ __('admin.Category') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Edit') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Edit Category') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.category.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('admin.Language') }}</label>
                            <select name="language" class="form-control @error('language') is-invalid @enderror">
                                <option value="">--- {{ __('admin.Select') }} ---</option>
                                @foreach ($languages as $language)
                                    <option @if ($language->language === $category->language) selected @endif
                                        value="{{ $language->language }}">
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Name') }}</label>
                            <input type="text" name="name" value="{{ $category->name }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Show at Navigation') }}?</label>
                            <select name="show_at_navigation"
                                class="form-control @error('show_at_navigation') is-invalid @enderror">
                                <option {{ $category->show_at_navigation === 0 ? 'selected' : '' }} value="0">
                                    {{ __('admin.No') }}
                                </option>
                                <option {{ $category->show_at_navigation === 1 ? 'selected' : '' }} value="1">
                                    {{ __('admin.Yes') }}
                                </option>
                            </select>
                            @error('show_at_navigation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Status') }}</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option {{ $category->status === 1 ? 'selected' : '' }} value="1">
                                    {{ __('admin.Active') }}
                                </option>
                                <option {{ $category->status === 0 ? 'selected' : '' }} value="0">
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
