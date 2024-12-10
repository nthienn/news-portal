@extends('admin.layouts.master')

@section('title', __('admin.Create New Language'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Create New Language') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.language.index') }}">{{ __('admin.Language') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Create New') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Create New Language') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.language.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('admin.Language') }}</label>
                            <select name="language" id="language"
                                class="form-control @error('language') is-invalid @enderror">
                                <option value="">--- {{ __('admin.Select') }} ---</option>
                                @foreach (config('language') as $key => $lang)
                                    <option value="{{ $key }}">{{ $lang['name'] }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Name') }}</label>
                            <input type="text" name="name" id="name" readonly
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Slug') }}</label>
                            <input type="text" name="slug" id="slug" readonly
                                class="form-control @error('slug') is-invalid @enderror">
                            @error('slug')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Is it default') }}?</label>
                            <select name="default" class="form-control @error('default') is-invalid @enderror">
                                <option value="0">{{ __('admin.No') }}</option>
                                <option value="1">{{ __('admin.Yes') }}</option>
                            </select>
                            @error('default')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Status') }}</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1">{{ __('admin.Active') }}</option>
                                <option value="0">{{ __('admin.Inactive') }}</option>
                            </select>
                            @error('status')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('admin.Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#language').change(function() {
                let name = $(this).children(':selected').text();
                let value = $(this).val();
                $('#name').val(name);
                $('#slug').val(value);
            });
        });
    </script>
@endpush
