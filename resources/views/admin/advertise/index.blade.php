@extends('admin.layouts.master')

@section('title', __('admin.Advertise'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Advertise') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.advertise.index') }}">{{ __('admin.Advertise') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Create New') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Advertise') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.advertise.update', 1) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h5>{{ __('admin.Top bar Advertise') }}</h5>
                        <label class="custom-switch mt-2">
                            <input @if ($ad->top_bar_ad_status == 1) checked @endif type="checkbox" value="1"
                                name="top_bar_ad_status" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <div class="form-group">
                            <label>{{ __('admin.Image') }}</label>
                            <br>
                            <img src="{{ asset($ad->top_bar_ad) }}" width="200px" alt="">
                            <input type="file" name="top_bar_ad"
                                class="form-control @error('top_bar_ad') is-invalid @enderror">
                            @error('top_bar_ad')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Url') }}</label>
                            <input type="text" name="top_bar_ad_url" value="{{ $ad->top_bar_ad_url }}"
                                class="form-control @error('top_bar_ad_url') is-invalid @enderror">
                            @error('top_bar_ad_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5>{{ __('admin.Middle Advertise') }}</h5>
                        <label class="custom-switch mt-2">
                            <input @if ($ad->middle_ad_status == 1) checked @endif type="checkbox" value="1"
                                name="middle_ad_status" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <div class="form-group">
                            <label>{{ __('admin.Image') }}</label>
                            <br>
                            <img src="{{ asset($ad->middle_ad) }}" width="200px" alt="">
                            <input type="file" name="middle_ad"
                                class="form-control @error('middle_ad') is-invalid @enderror">
                            @error('middle_ad')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Url') }}</label>
                            <input type="text" name="middle_ad_url" value="{{ $ad->middle_ad_url }}"
                                class="form-control @error('middle_ad_url') is-invalid @enderror">
                            @error('middle_ad_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5>{{ __('admin.Bottom bar Advertise') }}</h5>
                        <label class="custom-switch mt-2">
                            <input @if ($ad->bottom_bar_ad_status == 1) checked @endif type="checkbox" value="1"
                                name="bottom_bar_ad_status" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <div class="form-group">
                            <label>{{ __('admin.Image') }}</label>
                            <br>
                            <img src="{{ asset($ad->bottom_bar_ad) }}" width="200px" alt="">
                            <input type="file" name="bottom_bar_ad"
                                class="form-control @error('bottom_bar_ad') is-invalid @enderror">
                            @error('bottom_bar_ad')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Url') }}</label>
                            <input type="text" name="bottom_bar_ad_url" value="{{ $ad->bottom_bar_ad_url }}"
                                class="form-control @error('bottom_bar_ad_url') is-invalid @enderror">
                            @error('bottom_bar_ad_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5>{{ __('admin.Sidebar Advertise') }}</h5>
                        <label class="custom-switch mt-2">
                            <input @if ($ad->sidebar_ad_status == 1) checked @endif type="checkbox" value="1"
                                name="sidebar_ad_status" class="custom-switch-input toggle-status">
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <div class="form-group">
                            <label>{{ __('admin.Image') }}</label>
                            <br>
                            <img src="{{ asset($ad->sidebar_ad) }}" width="200px" alt="">
                            <input type="file" name="sidebar_ad"
                                class="form-control @error('sidebar_ad') is-invalid @enderror">
                            @error('sidebar_ad')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Url') }}</label>
                            <input type="text" name="sidebar_ad_url" value="{{ $ad->sidebar_ad_url }}"
                                class="form-control @error('sidebar_ad_url') is-invalid @enderror">
                            @error('sidebar_ad_url')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
