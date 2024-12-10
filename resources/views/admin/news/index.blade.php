@extends('admin.layouts.master')

@section('title', __('admin.News'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.News') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.News') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.News') }}</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
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
                                if (canAccess('news all-access')) {
                                    $news = \App\Models\News::with('category')
                                        ->where('language', $language->language)
                                        ->where('is_approved', 1)
                                        ->orderBy('id', 'DESC')
                                        ->get();
                                } else {
                                    $news = \App\Models\News::with('category')
                                        ->where('language', $language->language)
                                        ->where('is_approved', 1)
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

                                                @if (canAccess('news status') || canAccess('news all-access'))
                                                    <th>{{ __('admin.Breaking News') }}</th>
                                                    <th>{{ __('admin.Show at Slider') }}</th>
                                                    <th>{{ __('admin.Show at Popular') }}</th>
                                                @endif

                                                <th>{{ __('admin.Status') }}</th>
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

                                                    @if (canAccess('news status') || canAccess('news all-access'))
                                                        <td>
                                                            <label class="custom-switch mt-2">
                                                                <input
                                                                    {{ $value->is_breaking_news === 1 ? 'checked' : '' }}
                                                                    data-id="{{ $value->id }}"
                                                                    data-name="is_breaking_news" type="checkbox"
                                                                    value="1"
                                                                    class="custom-switch-input toggle-status">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="custom-switch mt-2">
                                                                <input {{ $value->show_at_slider === 1 ? 'checked' : '' }}
                                                                    data-id="{{ $value->id }}"
                                                                    data-name="show_at_slider" type="checkbox"
                                                                    value="1"
                                                                    class="custom-switch-input toggle-status">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="custom-switch mt-2">
                                                                <input {{ $value->show_at_popular === 1 ? 'checked' : '' }}
                                                                    data-id="{{ $value->id }}"
                                                                    data-name="show_at_popular" type="checkbox"
                                                                    value="1"
                                                                    class="custom-switch-input toggle-status">
                                                                <span class="custom-switch-indicator"></span>
                                                            </label>
                                                        </td>
                                                    @endif

                                                    <td>
                                                        <label class="custom-switch mt-2">
                                                            <input {{ $value->status === 1 ? 'checked' : '' }}
                                                                data-id="{{ $value->id }}" data-name="status"
                                                                type="checkbox" value="1"
                                                                class="custom-switch-input toggle-status">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
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
            $('.toggle-status').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.toggle-news-status') }}",
                    data: {
                        id: id,
                        name: name,
                        status: status
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: "success",
                                title: response.message
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
