<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ $settings['site_seo_title'] }}
        @endif
    </title>
    <meta name="description"
        content="@hasSection('meta_description')
@yield('meta_description')
@else
{{ $settings['site_seo_description'] }}
@endif">
    <meta name="keywords" content="{{ $settings['site_seo_keywords'] }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="og:title" content="@yield('meta_og_title')">
    <meta name="og:description" content="@yield('meta_og_description')">
    <meta name="og:image"
        content="@hasSection('meta_og_image')
@yield('meta_og_image')
@else
{{ asset($settings['site_logo']) }}
@endif">

    <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">

    <style>
        :root {
            --colorPrimary: {{ $settings['site_color'] }}
        }
    </style>
</head>

<body>
    @php
        $socials = \App\Models\SocialMedia::where('status', 1)->get();
    @endphp

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->

    @yield('content')

    <!-- Footer news -->
    @include('frontend.layouts.footer')
    <!-- End Footer news -->

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>

    <!-- Sweet Alert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])

    <script>
        // csrf token in ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // toast message
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        $(document).ready(function() {
            // change language
            $('#site-language').change(function() {
                const languageCode = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });

            // subscribe newsletter
            $('.newsletter-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.newsletter-button').text("{{ __('frontend.Loading...') }}");
                        $('.newsletter-button').attr('disabled', true);
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Toast.fire({
                                icon: "success",
                                title: response.message
                            });
                            $('.newsletter-form')[0].reset();
                            $('.newsletter-button').text("{{ __('frontend.Sign Up') }}");
                            $('.newsletter-button').attr('disabled', false);
                        }
                    },
                    error: function(response) {
                        $('.newsletter-button').text("{{ __('frontend.Sign Up') }}");
                        $('.newsletter-button').attr('disabled', false);
                        if (response.status === 422) {
                            const errors = response.responseJSON.errors;
                            $.each(errors, function(index, value) {
                                Toast.fire({
                                    icon: "error",
                                    title: value[0]
                                });
                            })
                        }
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
