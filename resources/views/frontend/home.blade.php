@extends('frontend.layouts.master')

@section('content')
    <!-- Breaking news carousel-->
    @include('frontend.components.breaking-news')
    <!-- End Breaking news carousel -->

    <!-- Popular news -->
    @include('frontend.components.popular-news')
    <!-- End Popular news -->

    @if ($advertise->top_bar_ad_status == 1)
        <div class="large_add_banner">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="large_add_banner_img">
                            <a href="{{ $advertise->top_bar_ad_url }}">
                                <img src="{{ asset($advertise->top_bar_ad) }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main news -->
    @include('frontend.components.main-news')
    <!-- End Main news -->
@endsection
