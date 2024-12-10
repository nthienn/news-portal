@extends('admin.layouts.master')

@section('title', __('admin.About Page'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.About Page') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.About Page') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.About Page Setting') }}</h4>
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
                                $about = \App\Models\About::where('language', $language->language)->first();
                            @endphp
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">
                                <form method="POST" action="{{ route('admin.about.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="hidden" name="language" value="{{ $language->language }}">
                                        <label>{{ __('admin.About Content') }}</label>
                                        <textarea name="content" class="summernote-{{ $language->language }}">
                                            {{ @$about->content }}
                                        </textarea>
                                        @error('content')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                                    </div>
                                </form>
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

        if (jQuery().summernote) {
            @foreach ($languages as $language)
                $('.summernote-{{ $language->language }}').summernote({
                    dialogsInBody: true,
                    minHeight: 250
                });
            @endforeach
        }
    </script>
@endpush
