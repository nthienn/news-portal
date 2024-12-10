@extends('admin.layouts.master')

@section('title', __('admin.Language'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Language') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Language') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Language') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.language.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('admin.Create New') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('admin.Name') }}</th>
                                    <th>{{ __('admin.Code') }}</th>
                                    <th>{{ __('admin.Default') }}</th>
                                    <th>{{ __('admin.Status') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($languages as $key => $language)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $language->name }}</td>
                                        <td>{{ $language->language }}</td>
                                        <td>
                                            @if ($language->default == 1)
                                                <div class="badge badge-success">{{ __('admin.Default') }}</div>
                                            @else
                                                <div class="badge badge-warning">{{ __('admin.No') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($language->status == 1)
                                                <div class="badge badge-success">{{ __('admin.Active') }}</div>
                                            @else
                                                <div class="badge badge-warning">{{ __('admin.Inactive') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.language.edit', $language) }}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.language.destroy', $language) }}"
                                                class="btn btn-danger delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
