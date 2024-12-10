@extends('admin.layouts.master')

@section('title', __('admin.Pending News'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Pending News') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Pending News') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Pending News') }}</h4>
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
                                if (canAccess('news all-access')) {
                                    $news = \App\Models\News::with('category')
                                        ->where('language', $language->language)
                                        ->where('is_approved', 0)
                                        ->orderBy('id', 'DESC')
                                        ->get();
                                } else {
                                    $news = \App\Models\News::with('category')
                                        ->where('language', $language->language)
                                        ->where('is_approved', 0)
                                        ->where('author_id', auth()->guard('admin')->user()->id)
                                        ->orderBy('id', 'DESC')
                                        ->get();
                                }
                            @endphp
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->language }}">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>{{ __('admin.Image') }}</th>
                                                <th>{{ __('admin.Title') }}</th>
                                                <th>{{ __('admin.Category') }}</th>
                                                <th>{{ __('admin.Approve') }}</th>
                                                <th>{{ __('admin.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($news as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>
                                                        <img src="{{ asset($value->image) }}" alt=""
                                                            width="100">
                                                    </td>
                                                    <td>{{ truncate($value->title, 30) }}</td>
                                                    <td>{{ $value->category->name }}</td>
                                                    <td>
                                                        @if (canAccess('news all-access'))
                                                            <form action="" id="approve_form">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $value->id }}">
                                                                <div class="form-group">
                                                                    <select name="is_approve" class="form-control"
                                                                        id="approve-input">
                                                                        <option value="0">{{ __('admin.Pending') }}
                                                                        </option>
                                                                        <option value="1">{{ __('admin.Approve') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div class="form-group">
                                                                <select class="form-control">
                                                                    <option>{{ __('admin.Pending') }}</option>
                                                                </select>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.news.edit', $value->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('admin.copy-news', $value->id) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-copy"></i>
                                                        </a>
                                                        <a href="{{ route('admin.news.destroy', $value->id) }}"
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

        $(document).ready(function() {
            $('#approve-input').change(function() {
                $('#approve_form').submit();
            });

            $('#approve_form').submit(function(e) {
                e.preventDefault();
                const data = $(this).serialize();
                $.ajax({
                    type: "PUT",
                    url: "{{ route('admin.approve-news') }}",
                    data: data,
                    success: function(response) {
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
