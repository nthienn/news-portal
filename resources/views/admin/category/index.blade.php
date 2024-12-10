@extends('admin.layouts.master')

@section('title', __('admin.Category'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Category') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Category') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Category') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> {{ __('admin.Create New') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach ($languages as $language)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" id="home-tab"
                                    data-toggle="tab" href="#home-{{ $language->language }}" role="tab"
                                    aria-controls="home" aria-selected="true">{{ $language->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @foreach ($languages as $language)
                            @php
                                $categories = \App\Models\Category::where('language', $language->language)
                                    ->orderBy('id', 'DESC')
                                    ->get();
                            @endphp
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->language }}">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>{{ __('admin.Name') }}</th>
                                                <th>{{ __('admin.Language') }}</th>
                                                <th>{{ __('admin.Show at Navigation') }}</th>
                                                <th>{{ __('admin.Status') }}</th>
                                                <th>{{ __('admin.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $key => $category)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $category->language }}</td>
                                                    <td>
                                                        @if ($category->show_at_navigation == 1)
                                                            <div class="badge badge-success">{{ __('admin.Yes') }}</div>
                                                        @else
                                                            <div class="badge badge-warning">{{ __('admin.No') }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($category->status == 1)
                                                            <div class="badge badge-success">{{ __('admin.Active') }}</div>
                                                        @else
                                                            <div class="badge badge-warning">{{ __('admin.Inactive') }}
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.category.edit', $category) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.category.destroy', $category) }}"
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        @foreach ($languages as $language)
            $("#table-{{ $language->language }}").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }]
            });
        @endforeach
    </script>
@endpush
