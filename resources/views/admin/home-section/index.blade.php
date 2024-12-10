@extends('admin.layouts.master')

@section('title', __('admin.Home Section'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Home Section') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Home Section') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Home Section Setting') }}</h4>
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
                                $homeSection = \App\Models\HomeSection::where('language', $language->language)->first();
                            @endphp
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">
                                <form method="POST" action="{{ route('admin.home-section.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="hidden" name="language" value="{{ $language->language }}">
                                        <label>{{ __('admin.Category Section One') }}</label>
                                        <select name="category_section_one"
                                            class="form-control @error('category_section_one') is-invalid @enderror">
                                            <option value="">--- {{ __('admin.Select') }} ---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (@$homeSection->category_section_one == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_section_one')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('admin.Category Section Two') }}</label>
                                        <select name="category_section_two"
                                            class="form-control @error('category_section_two') is-invalid @enderror">
                                            <option value="">--- {{ __('admin.Select') }} ---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (@$homeSection->category_section_two == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_section_two')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('admin.Category Section Three') }}</label>
                                        <select name="category_section_three"
                                            class="form-control @error('category_section_three') is-invalid @enderror">
                                            <option value="">--- {{ __('admin.Select') }} ---</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (@$homeSection->category_section_three == $category->id) selected @endif>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_section_three')
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
    </script>
@endpush
