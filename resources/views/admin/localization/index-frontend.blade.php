@extends('admin.layouts.master')

@section('title', __('admin.Frontend Localization'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Frontend Localization') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Frontend Localization') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Frontend Localization') }}</h4>
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
                            <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                                id="home-{{ $language->language }}" role="tabpanel" aria-labelledby="home-tab">

                                <div class="card-body d-flex">
                                    <form method="POST" action="{{ route('admin.generate-string') }}">
                                        @csrf
                                        <input type="hidden" name="directory"
                                            value="{{ resource_path('views/frontend') }}, {{ resource_path('views/auth') }}, {{ resource_path('views/mail') }}, {{ app_path('Http/Controllers/Frontend') }}">
                                        <input type="hidden" name="language" value="{{ $language->language }}">
                                        <input type="hidden" name="file_name" value="frontend">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-plus"></i> {{ __('admin.Generate Strings') }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.translate-string') }}"
                                        class="translate_form">
                                        <input type="hidden" name="language" value="{{ $language->language }}">
                                        <input type="hidden" name="file_name" value="frontend">
                                        <button type="submit" class="btn btn-dark translate_button">
                                            <i class="fas fa-plus"></i> {{ __('admin.Translate Strings') }}
                                        </button>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->language }}">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>{{ __('admin.String') }}</th>
                                                <th>{{ __('admin.Translation') }}</th>
                                                <th>{{ __('admin.Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $translatedValues = trans('frontend', [], $language->language);
                                            @endphp
                                            @foreach ($translatedValues as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{ ++$loop->index }}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $value }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info modal_btn"
                                                            data-toggle="modal" data-target="#exampleModal"
                                                            data-language="{{ $language->language }}"
                                                            data-key="{{ $key }}"
                                                            data-value="{{ $value }}" data-filename="frontend">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.Edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.update-string') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('admin.Value') }}</label>
                            <input type="text" name="value" class="form-control" value="">
                            <input type="hidden" name="language" class="form-control" value="">
                            <input type="hidden" name="key" class="form-control" value="">
                            <input type="hidden" name="file_name" class="form-control" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('admin.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            $('body').on('click', '.modal_btn', function() {
                const language = $(this).attr('data-language');
                const key = $(this).attr('data-key');
                const value = $(this).attr('data-value');
                const filename = $(this).attr('data-filename');

                $('input[name="language"]').val("");
                $('input[name="key"]').val("");
                $('input[name="value"]').val("");
                $('input[name="file_name"]').val("");

                $('input[name="language"]').val(language);
                $('input[name="key"]').val(key);
                $('input[name="value"]').val(value);
                $('input[name="file_name"]').val(filename);
            });

            $('.translate_form').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.translate-string') }}",
                    data: formData,
                    beforeSend: function() {
                        $('.translate_button').text(
                            "{{ __('admin.Translating! Please wait...') }}");
                        $('.translate_button').prop('disabled', true);
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.fire({
                                title: "{{ __('admin.Done!') }}",
                                text: data.message,
                                icon: "success"
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "{{ __('admin.Error!') }}",
                                text: data.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endpush
