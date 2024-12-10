@extends('admin.layouts.master')

@section('title', __('admin.Role and Permission'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Role and Permission') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Role and Permission') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Role and Permission') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">
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
                                    <th>{{ __('admin.Role Name') }}</th>
                                    <th>{{ __('admin.Permissions') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $permission)
                                                <div class="badge badge-primary">{{ $permission->name }}</div>
                                            @endforeach

                                            @if ($role->name === 'Admin')
                                                <div class="badge badge-success">* {{ __('admin.All Permissions') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($role->name != 'Admin')
                                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.role.destroy', $role->id) }}"
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
