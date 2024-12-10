@extends('admin.layouts.master')

@section('title', __('admin.Contact Page'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Contact Page') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Contact Page') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Contact Page Setting') }}</h4>
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
                                $contact = \App\Models\Contact::where('language', $language->language)->first();
                            @endphp
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">
                                <form method="POST" action="{{ route('admin.contact.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <input type="hidden" name="language" value="{{ $language->language }}">
                                        <label>{{ __('admin.Address') }}</label>
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            value="{{ @$contact->address }}">
                                        @error('address')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('admin.Phone') }}</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ @$contact->phone }}">
                                        @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('admin.Email') }}</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ @$contact->email }}">
                                        @error('email')
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
