@extends('admin.layouts.master')

@section('title', __('admin.Role User'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Role User') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Role User') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Role User') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.role-user.create') }}" class="btn btn-primary">
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
                                    <th>{{ __('admin.Email') }}</th>
                                    <th>{{ __('admin.Role') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $key => $admin)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            <div class="badge badge-primary">{{ $admin->getRoleNames()->first() }}</div>
                                        </td>
                                        <td>
                                            @if ($admin->getRoleNames()->first() != 'Admin')
                                                <a href="{{ route('admin.role-user.edit', $admin->id) }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.role-user.destroy', $admin->id) }}"
                                                    class="btn btn-danger delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @endif
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
