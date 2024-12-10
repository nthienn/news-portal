@extends('frontend.layouts.master')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumbs bg-light mb-4">
                        <li class="breadcrumbs__item">
                            <a href="{{ url('/') }}" class="breadcrumbs__url">
                                <i class="fa fa-home"></i> {{ __('frontend.Home') }}</a>
                        </li>
                        <li class="breadcrumbs__item">
                            <a href="javascript:void(0);" class="breadcrumbs__url">{{ __('frontend.About') }}</a>
                        </li>
                    </ul>
                    <!-- end breadcrumb -->

                    <div class="wrap__about-us">
                        {!! $about->content !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
