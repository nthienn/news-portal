@extends('admin.layouts.master')

@section('title', __('admin.Setting'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Setting') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Setting') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Setting') }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-2">
                            <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab4" data-toggle="tab" href="#general"
                                        role="tab" aria-controls="home" aria-selected="true">
                                        {{ __('admin.General Settings') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#seo" role="tab"
                                        aria-controls="profile" aria-selected="false">
                                        {{ __('admin.SEO Setting') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#appearance"
                                        role="tab" aria-controls="contact" aria-selected="false">
                                        {{ __('admin.Appearance Setting') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#api" role="tab"
                                        aria-controls="contact" aria-selected="false">
                                        {{ __('admin.Translate API Setting') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-12 col-md-10">
                            <div class="tab-content no-padding" id="myTab2Content">
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="home-tab4">
                                    @include('admin.setting.form.general-setting')
                                </div>
                                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="profile-tab4">
                                    @include('admin.setting.form.seo-setting')
                                </div>
                                <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="contact-tab4">
                                    @include('admin.setting.form.appearance-setting')
                                </div>
                                <div class="tab-pane fade" id="api" role="tabpanel" aria-labelledby="contact-tab4">
                                    @include('admin.setting.form.translate-api-setting')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
