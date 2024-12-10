@extends('frontend.layouts.master')

@section('content')
    <!-- Form contact -->
    <section class="wrap__contact-form">
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
                            <a href="javascript:void(0);" class="breadcrumbs__url">{{ __('frontend.Contact') }}</a>
                        </li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>

                <div class="col-md-8">
                    <h5>{{ __('frontend.Contact Us') }}</h5>
                    <form action="{{ route('contact.send') }}" method="POST">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('frontend.Your email') }}</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('frontend.Subject') }}</label>
                                    <input type="text" name="subject"
                                        class="form-control @error('subject') is-invalid @enderror">
                                    @error('subject')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ __('frontend.Your message') }}</label>
                                    <textarea class="form-control" rows="8" name="message"></textarea>
                                    @error('message')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group mb-4">
                                    <button type="submit" class="btn btn-primary">{{ __('frontend.Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-4">
                    <h5>{{ __('frontend.Info Location') }}</h5>
                    <div class="wrap__contact-form-office">
                        <ul class="list-unstyled">
                            <li>
                                <span><i class="fa fa-home"></i></span>
                                {{ $contact->address }}
                            </li>
                            <li>
                                <span>
                                    <i class="fa fa-phone"></i>
                                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                </span>
                            </li>
                            <li>
                                <span>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </span>
                            </li>
                        </ul>

                        <div class="social__media">
                            <h5>{{ __('frontend.Find Us') }}</h5>
                            <ul class="list-inline">
                                @foreach ($socials as $social)
                                    <li class="list-inline-item">
                                        <a href="{{ $social->url }}" class="btn btn-social rounded text-white"
                                            style="background-color: {{ $social->background_color }}">
                                            <i class="{{ $social->icon }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Form contact  -->
@endsection
