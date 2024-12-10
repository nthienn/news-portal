<section class="pt-0 mt-5 pb-80">
    <div class="popular__section-news">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="wrapper__list__article">
                        <h4 class="border_section">{{ __('frontend.Recent News') }}</h4>
                    </div>
                    <div class="row ">
                        @foreach ($recentNews as $news)
                            @if ($loop->index <= 1)
                                <div class="col-sm-12 col-md-6 mb-4">
                                    <!-- Post Article -->
                                    <div class="card__post ">
                                        <div class="card__post__body card__post__transition">
                                            <a href="{{ route('news-detail', $news->slug) }}">
                                                <img src="{{ asset($news->image) }}" class="img-fluid" alt="">
                                            </a>
                                            <div class="card__post__content bg__post-cover">
                                                <div class="card__post__category">
                                                    {{ $news->category->name }}
                                                </div>
                                                <div class="card__post__title">
                                                    <h5>
                                                        <a href="{{ route('news-detail', $news->slug) }}">
                                                            {{ truncate($news->title) }}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div class="card__post__author-info">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <span>
                                                                {{ __('frontend.By') }}
                                                                {{ $news->author->name }}
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span>
                                                                {{ date('d-m-Y', strtotime($news->created_at)) }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row ">
                        @foreach ($recentNews as $news)
                            @if ($loop->index > 1 && $loop->index <= 5)
                                <div class="col-sm-12 col-md-6">
                                    <div class="wrapp__list__article-responsive">
                                        <div class="mb-3">
                                            <!-- Post Article -->
                                            <div class="card__post card__post-list">
                                                <div class="image-sm">
                                                    <a href="{{ route('news-detail', $news->slug) }}">
                                                        <img src="{{ asset($news->image) }}" class="img-fluid"
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
                                                                        {{ $news->author->name }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <span class="text-dark text-capitalize">
                                                                        {{ date('d-m-Y', strtotime($news->created_at)) }}
                                                                    </span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-detail', $news->slug) }}">
                                                                    {{ truncate($news->title) }}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <aside class="wrapper__list__article">
                        <h4 class="border_section">{{ __('frontend.Popular post') }}</h4>
                        <div class="wrapper__list-number">
                            @foreach ($popularNews as $news)
                                <!-- List Article -->
                                <div class="card__post__list">
                                    <div class="list-number">
                                        <span>{{ ++$loop->index }}</span>
                                    </div>
                                    <a href="javascript:void(0);" class="category">
                                        {{ $news->category->name }}
                                    </a>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5>
                                                <a href="{{ route('news-detail', $news->slug) }}">
                                                    {{ truncate($news->title) }}
                                                </a>
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <!-- Post news carousel -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <aside class="wrapper__list__article">
                    <h4 class="border_section">{{ @$categorySectionOne->first()->category->name }}</h4>
                </aside>
            </div>
            <div class="col-md-12">
                <div class="article__entry-carousel">
                    @foreach ($categorySectionOne as $sectionOneNews)
                        <div class="item">
                            <!-- Post Article -->
                            <div class="article__entry">
                                <div class="article__image">
                                    <a href="{{ route('news-detail', $sectionOneNews->slug) }}">
                                        <img src="{{ asset($sectionOneNews->image) }}" alt=""
                                            class="img-fluid">
                                    </a>
                                </div>
                                <div class="article__content">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <span class="text-primary">
                                                {{ __('frontend.By') }} {{ $sectionOneNews->author->name }}
                                            </span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span>
                                                {{ date('d-m-Y', strtotime($sectionOneNews->created_at)) }}
                                            </span>
                                        </li>
                                    </ul>
                                    <h5>
                                        <a href="{{ route('news-detail', $sectionOneNews->slug) }}">
                                            {{ truncate($sectionOneNews->title) }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Popular news category -->

    <!-- Popular news category -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <aside class="wrapper__list__article mb-0">
                        <h4 class="border_section">{{ @$categorySectionTwo->first()->category->name }}</h4>
                        <div class="row">
                            @foreach ($categorySectionTwo as $sectionTwoNews)
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <!-- Post Article -->
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-detail', $sectionTwoNews->slug) }}">
                                                    <img src="{{ asset($sectionTwoNews->image) }}" alt=""
                                                        class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <span class="text-primary">
                                                            {{ __('frontend.By') }}
                                                            {{ $sectionTwoNews->author->name }}
                                                        </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span>
                                                            {{ date('d-m-Y', strtotime($sectionTwoNews->created_at)) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                                <h5>
                                                    <a href="{{ route('news-detail', $sectionTwoNews->slug) }}">
                                                        {{ truncate($sectionTwoNews->title) }}
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </aside>

                    @if ($advertise->middle_ad_status == 1)
                        <div class="small_add_banner">
                            <div class="small_add_banner_img">
                                <a href="{{ $advertise->middle_ad_url }}">
                                    <img src="{{ asset($advertise->middle_ad) }}" alt="">
                                </a>
                            </div>
                        </div>
                    @endif

                    <aside class="wrapper__list__article mt-5">
                        <h4 class="border_section">{{ @$categorySectionThree->first()->category->name }}</h4>
                        <div class="wrapp__list__article-responsive">
                            @foreach ($categorySectionThree as $sectionThreeNews)
                                <!-- Post Article List -->
                                <div class="card__post card__post-list card__post__transition mt-30">
                                    <div class="row ">
                                        <div class="col-md-5">
                                            <div class="card__post__transition">
                                                <a href="{{ route('news-detail', $sectionThreeNews->slug) }}">
                                                    <img src="{{ asset($sectionThreeNews->image) }}"
                                                        class="img-fluid w-100" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-7 my-auto pl-0">
                                            <div class="card__post__body ">
                                                <div class="card__post__content  ">
                                                    <div class="card__post__category ">
                                                        {{ $sectionThreeNews->category->name }}
                                                    </div>
                                                    <div class="card__post__author-info mb-2">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <span class="text-primary">
                                                                    {{ __('frontend.By') }}
                                                                    {{ $sectionThreeNews->author->name }}
                                                                </span>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <span class="text-dark text-capitalize">
                                                                    {{ date('d-m-Y', strtotime($sectionThreeNews->created_at)) }}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card__post__title">
                                                        <h5>
                                                            <a
                                                                href="{{ route('news-detail', $sectionThreeNews->slug) }}">
                                                                {{ truncate($sectionThreeNews->title) }}
                                                            </a>
                                                        </h5>
                                                        <p class="d-none d-lg-block d-xl-block mb-0">
                                                            {!! truncate($sectionThreeNews->content, 100) !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </aside>
                </div>

                <div class="col-md-4">
                    <div class="sticky-top">
                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('frontend.Most viewed post') }}</h4>
                            <div class="wrapper__list__article-small">
                                @foreach ($mostViewedPost as $post)
                                    @if ($loop->index === 0)
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
                                                            {{ __('frontend.By') }} {{ $post->author->name }}
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
                                    @endif
                                @endforeach
                                @foreach ($mostViewedPost as $post)
                                    @if ($loop->index > 0 && $loop->index <= 2)
                                        <div class="mb-3">
                                            <!-- Post Article -->
                                            <div class="card__post card__post-list">
                                                <div class="image-sm">
                                                    <a href="{{ route('news-detail', $post->slug) }}">
                                                        <img src="{{ asset($post->image) }}" alt=""
                                                            class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="card__post__body ">
                                                    <div class="card__post__content">
                                                        <div class="card__post__author-info mb-2">
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
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-detail', $post->slug) }}">
                                                                    {{ truncate($post->title) }}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
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
                                            placeholder="Your email address">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary newsletter-button" type="submit">
                                                {{ __('frontend.Sign Up') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </aside>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
