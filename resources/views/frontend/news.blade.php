@extends('frontend.layouts.master')

@section('content')
    <section class="pb-80">
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
                            <a href="javascript:void(0);" class="breadcrumbs__url">{{ __('frontend.News') }}</a>
                        </li>
                    </ul>
                    <!-- end breadcrumb -->
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="blog_page_search">
                            <form method="GET" action="{{ route('news') }}">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" placeholder="{{ __('frontend.Search') }}" name="search"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="category">
                                            <option value="">{{ __('frontend.Select Category') }}</option>
                                            @foreach ($categories as $category)
                                                <option @if ($category->slug === request()->category) selected @endif
                                                    value="{{ $category->slug }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit">{{ __('frontend.Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <aside class="wrapper__list__article ">
                            @if (request()->has('tag'))
                                <h4 class="border_section">{{ __('frontend.Tag') }}: #{{ request()->tag }}</h4>
                            @endif
                            <div class="row">
                                @foreach ($news as $post)
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <!-- Post Article -->
                                            <div class="article__entry">
                                                <div class="article__image">
                                                    <a href="{{ route('news-detail', $post->slug) }}">
                                                        <img src="{{ asset($post->image) }}" alt=""
                                                            class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="article__content">
                                                    <div class="article__category">
                                                        {{ $post->category->name }}
                                                    </div>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <span class="text-primary">
                                                                {{ __('frontend.By') }}
                                                                {{ $post->author->name }}
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span class="text-dark text-capitalize">
                                                                {{ date('d-m-Y', strtotime($post->created_at)) }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <h5>
                                                        <a href="{{ route('news-detail', $post->slug) }}">
                                                            {{ truncate($post->title) }}
                                                        </a>
                                                    </h5>
                                                    <p>{!! truncate($post->content, 100) !!}</p>
                                                    <a href="{{ route('news-detail', $post->slug) }}"
                                                        class="btn btn-outline-primary mb-4 text-capitalize">
                                                        {{ __('frontend.Read More') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($news) === 0)
                                <h2>{{ __('frontend.No News Found') }} :(</h2>
                                <img src="{{ asset('frontend/assets/images/noresult.jpg') }}" alt="">
                            @endif
                        </aside>
                    </div>

                    <div class="col-md-4">
                        <div class="sticky-top">
                            <aside class="wrapper__list__article">
                                <h4 class="border_section">{{ __('frontend.Recent News') }}</h4>
                                <div class="wrapper__list__article-small">
                                    @foreach ($recentNews as $value)
                                        @if ($loop->index <= 2)
                                            <div class="mb-3">
                                                <!-- Post Article -->
                                                <div class="card__post card__post-list">
                                                    <div class="image-sm">
                                                        <a href="{{ route('news-detail', $value->slug) }}">
                                                            <img src="{{ asset($value->image) }}" class="img-fluid"
                                                                alt="">
                                                        </a>
                                                    </div>
                                                    <div class="card__post__body ">
                                                        <div class="card__post__content">
                                                            <div class="card__post__author-info mb-2">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item">
                                                                        <span class="text-primary">
                                                                            {{ __('frontend.By') }}
                                                                            {{ $value->author->name }}
                                                                        </span>
                                                                    </li>
                                                                    <li class="list-inline-item">
                                                                        <span class="text-dark text-capitalize">
                                                                            {{ date('d-m-Y', strtotime($value->created_at)) }}
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="card__post__title">
                                                                <h6>
                                                                    <a href="{{ route('news-detail', $value->slug) }}">
                                                                        {{ truncate($value->title) }}
                                                                    </a>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($loop->index == 3)
                                            <!-- Post Article -->
                                            <div class="article__entry">
                                                <div class="article__image">
                                                    <a href="{{ route('news-detail', $value->slug) }}">
                                                        <img src="{{ asset($value->image) }}" alt=""
                                                            class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="article__content">
                                                    <div class="article__category">
                                                        {{ $value->category->name }}
                                                    </div>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <span class="text-primary">
                                                                {{ __('frontend.By') }}
                                                                {{ $value->author->name }}
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span class="text-dark text-capitalize">
                                                                {{ date('d-m-Y', strtotime($value->created_at)) }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <h5>
                                                        <a href="{{ route('news-detail', $value->slug) }}">
                                                            {{ truncate($value->title) }}
                                                        </a>
                                                    </h5>
                                                    <p>
                                                        {!! truncate($value->content, 100) !!}
                                                    </p>
                                                    <a href="{{ route('news-detail', $value->slug) }}"
                                                        class="btn btn-outline-primary mb-4 text-capitalize">
                                                        {{ __('frontend.Read More') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </aside>

                            <aside class="wrapper__list__article">
                                <h4 class="border_section">{{ __('frontend.Tags') }}</h4>
                                <div class="blog-tags p-0">
                                    <ul class="list-inline">
                                        @foreach ($mostCommonTags as $tag)
                                            <li class="list-inline-item">
                                                <a href="{{ route('news', ['tag' => $tag->name]) }}">
                                                    #{{ $tag->name }} ({{ $tag->count }})
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </aside>

                            <aside class="wrapper__list__article">
                                <h4 class="border_section">{{ __('frontend.Newsletter') }}</h4>
                                <!-- Form Subscribe -->
                                <div class="widget__form-subscribe bg__card-shadow">
                                    <h6>{{ __('frontend.The most important world news and events of the day') }}.
                                    </h6>
                                    <p><small>{{ __('frontend.Get daily newsletter on your inbox') }}.</small></p>
                                    <form action="" class="newsletter-form">
                                        <div class="input-group">
                                            <input type="text" name="email" class="form-control"
                                                placeholder="{{ __('frontend.Your email address') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary newsletter-button" type="submit">
                                                    {{ __('frontend.Sign Up') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </aside>

                            @if ($advertise->sidebar_ad_status == 1)
                                <aside class="wrapper__list__article">
                                    <h4 class="border_section">{{ __('frontend.Advertise') }}</h4>
                                    <a href="{{ $advertise->sidebar_ad_url }}">
                                        <figure>
                                            <img src="{{ asset($advertise->sidebar_ad) }}" alt=""
                                                class="img-fluid">
                                        </figure>
                                    </a>
                                </aside>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination-area">
                    {{ $news->appends(request()->query())->links() }}
                </div>
            </div>

            @if ($advertise->bottom_bar_ad_status == 1)
                <div class="large_add_banner mt-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="large_add_banner_img">
                                    <a href="{{ $advertise->bottom_bar_ad_url }}">
                                        <img src="{{ asset($advertise->bottom_bar_ad) }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </section>
@endsection
