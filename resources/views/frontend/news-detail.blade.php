@extends('frontend.layouts.master')

<!-- Setting metas -->
@section('title', $news->title)
@section('meta_description', $news->meta_description)
@section('meta_og_title', $news->meta_title)
@section('meta_og_description', $news->meta_description)
@section('meta_og_image', asset($news->image))
<!-- End Setting metas -->

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

                <div class="col-md-8">
                    <!-- content article detail -->
                    <!-- Article Detail -->
                    <div class="wrap__article-detail">
                        <div class="wrap__article-detail-title">
                            <h1>{{ $news->title }}</h1>
                        </div>
                        <hr>
                        <div class="wrap__article-detail-info">
                            <ul class="list-inline d-flex flex-wrap justify-content-start">
                                <li class="list-inline-item">
                                    {{ __('frontend.By') }}
                                    <a href="">{{ $news->author->name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <span class="text-dark text-capitalize ml-1">
                                        {{ date('d-m-Y', strtotime($news->created_at)) }}
                                    </span>
                                </li>
                                <li class="list-inline-item">
                                    <span class="text-dark text-capitalize">
                                        {{ __('frontend.In') }}
                                    </span>
                                    <a href="javascript:void(0);">{{ $news->category->name }}</a>
                                </li>
                            </ul>
                        </div>

                        <div class="wrap__article-detail-image mt-4">
                            <figure>
                                <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                            </figure>
                        </div>
                        <div class="wrap__article-detail-content">
                            <div class="total-views">
                                <div class="total-views-read">
                                    {{ convertToKFormat($news->views) }}
                                    <span>{{ __('frontend.Views') }}</span>
                                </div>
                                <ul class="list-inline">
                                    <span class="share">{{ __('frontend.Share on') }}:</span>
                                    <li class="list-inline-item">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                            target="_blank" class="btn btn-social-o facebook">
                                            <i class="fa fa-facebook-f"></i>
                                            <span>{{ __('frontend.Facebook') }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://twitter.com/intent/tweet?text={{ $news->title }}&url={{ url()->current() }}"
                                            target="_blank" class="btn btn-social-o twitter">
                                            <i class="fa fa-twitter"></i>
                                            <span>{{ __('frontend.Twitter') }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://wa.me/?text={{ $news->title }}%20{{ url()->current() }}"
                                            target="_blank" class="btn btn-social-o whatsapp">
                                            <i class="fa fa-whatsapp"></i>
                                            <span>{{ __('frontend.Whatsapp') }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://t.me/share/url?url={{ url()->current() }}&text={{ $news->title }}"
                                            target="_blank" class="btn btn-social-o telegram">
                                            <i class="fa fa-telegram"></i>
                                            <span>{{ __('frontend.Telegram') }}</span>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}&title={{ $news->title }}"
                                            target="_blank" class="btn btn-linkedin-o linkedin">
                                            <i class="fa fa-linkedin"></i>
                                            <span>{{ __('frontend.Linkedin') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <p class="has-drop-cap-fluid">
                                {!! $news->content !!}
                            </p>
                        </div>
                        <!-- end content article detail -->

                        <!-- tags -->
                        <!-- News Tags -->
                        <div class="blog-tags">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <i class="fa fa-tags"></i>
                                </li>
                                @foreach ($news->tags as $tag)
                                    <li class="list-inline-item">
                                        <a href="{{ route('news', ['tag' => $tag->name]) }}">#{{ $tag->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- end tags-->

                        <!-- authors-->
                        <!-- Profile author -->
                        <div class="wrap__profile">
                            <div class="wrap__profile-author">
                                <figure>
                                    <img src="{{ asset($news->author->image) }}" alt=""
                                        class="img-fluid rounded-circle" style="width:250px; height:200px">
                                </figure>
                                <div class="wrap__profile-author-detail">
                                    <div class="wrap__profile-author-detail-name">
                                        {{ $news->author->getRoleNames()->first() }}
                                    </div>
                                    <h4>{{ $news->author->name }}</h4>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    </p>
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
                        <!-- end author-->

                        <!-- Comment  -->
                        @auth
                            <div id="comments" class="comments-area">
                                <h3 class="comments-title">{{ $news->comments()->count() }}
                                    {{ __('frontend.Comments') }}</h3>
                                <ol class="comment-list">
                                    @foreach ($news->comments()->whereNull('parent_id')->get() as $comment)
                                        <li class="comment">
                                            <aside class="comment-body">
                                                <div class="comment-meta">
                                                    <div class="comment-author vcard">
                                                        <img src="{{ asset('admin/assets/img/avatar/avatar-1.png') }}"
                                                            class="avatar" alt="image">
                                                        <b class="fn">{{ $comment->user->name }}</b>
                                                    </div>
                                                    <div class="comment-metadata">
                                                        <span>
                                                            {{ date('d-m-Y H:i', strtotime($comment->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="comment-content">
                                                    <p>{{ $comment->comment }}</p>
                                                </div>

                                                <div class="reply">
                                                    <a href="#" class="comment-reply-link" data-toggle="modal"
                                                        data-target="#exampleModal-{{ $comment->id }}">
                                                        {{ __('frontend.Reply') }}
                                                    </a>
                                                    <span class="delete" data-id="{{ $comment->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </span>
                                                </div>
                                            </aside>

                                            @if ($comment->reply()->count() > 0)
                                                @foreach ($comment->reply as $reply)
                                                    <ol class="children">
                                                        <li class="comment">
                                                            <aside class="comment-body">
                                                                <div class="comment-meta">
                                                                    <div class="comment-author vcard">
                                                                        <img src="{{ asset('admin/assets/img/avatar/avatar-1.png') }}"
                                                                            class="avatar" alt="image">
                                                                        <b class="fn">{{ $reply->user->name }}</b>
                                                                    </div>
                                                                    <div class="comment-metadata">
                                                                        <span>
                                                                            {{ date('d-m-Y H:i', strtotime($reply->created_at)) }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="comment-content">
                                                                    <p>{{ $reply->comment }}</p>
                                                                </div>
                                                                <div class="reply">
                                                                    <a href="#" class="comment-reply-link"
                                                                        data-toggle="modal"
                                                                        data-target="#exampleModal-{{ $comment->id }}">
                                                                        {{ __('frontend.Reply') }}
                                                                    </a>
                                                                    <span class="delete" data-id="{{ $reply->id }}">
                                                                        <i class="fa fa-trash"></i>
                                                                    </span>
                                                                </div>
                                                            </aside>
                                                        </li>
                                                    </ol>
                                                @endforeach
                                            @endif
                                        </li>

                                        <!-- Modal reply comment -->
                                        <div class="comment_modal">
                                            <div class="modal fade" id="exampleModal-{{ $comment->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                {{ __('frontend.Write Your Comment') }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('news-comment-reply') }}" method="POST">
                                                                @csrf
                                                                <textarea name="reply_comment" cols="30" rows="7" placeholder="{{ __('frontend.Comment') }}. . ."></textarea>
                                                                <input type="hidden" name="news_id"
                                                                    value="{{ $news->id }}">
                                                                <input type="hidden" name="parent_id"
                                                                    value="{{ $comment->id }}">
                                                                @error('reply_comment')
                                                                    <p class="text-danger">{{ $message }}</p>
                                                                @enderror
                                                                <button type="submit">{{ __('frontend.Reply') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ol>
                                <div class="comment-respond">
                                    <h3 class="comment-reply-title">{{ __('frontend.Leave a Comment') }}</h3>
                                    <form method="POST" action="{{ route('news-comment') }}" class="comment-form">
                                        @csrf
                                        <p class="comment-notes">
                                            <span id="email-notes">
                                                * {{ __('frontend.Your email address will not be published.') }}
                                            </span>
                                        </p>
                                        <p class="comment-form-comment">
                                            <label for="comment">{{ __('frontend.Comment') }}</label>
                                            <textarea name="comment" id="comment" cols="45" rows="5" maxlength="65525" required="required"></textarea>
                                            <input type="hidden" name="news_id" value="{{ $news->id }}">
                                            <input type="hidden" name="parent_id" value="">
                                        </p>
                                        @error('comment')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="form-submit mb-0">
                                            <input type="submit" name="submit" id="submit" class="submit"
                                                value="{{ __('frontend.Comment') }}">
                                        </p>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div id="comments" class="comments-area">
                                <div class="comment-respond">
                                    <h3 class="comment-reply-title">{{ __('frontend.Please') }}
                                        <a href="{{ route('login') }}">{{ __('frontend.Login') }}</a>
                                        {{ __('frontend.to comment in the post') }}!
                                    </h3>
                                </div>
                            </div>
                        @endauth
                        <!-- end comment -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="single_navigation-prev">
                                    @if ($previousPost)
                                        <a href="{{ route('news-detail', $previousPost->slug) }}">
                                            <span>{{ __('frontend.Previous post') }}</span>
                                            {{ truncate($previousPost->title, 100) }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_navigation-next text-left text-md-right">
                                    @if ($nextPost)
                                        <a href="{{ route('news-detail', $nextPost->slug) }}">
                                            <span>{{ __('frontend.Next post') }}</span>
                                            {{ truncate($nextPost->title, 100) }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if ($advertise->middle_ad_status == 1)
                            <div class="small_add_banner mb-5 pb-4">
                                <div class="small_add_banner_img">
                                    <a href="{{ $advertise->middle_ad_url }}">
                                        <img src="{{ asset($advertise->middle_ad) }}" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div class="clearfix"></div>

                        @if (count($relatedPosts) > 0)
                            <div class="related-article">
                                <h4>{{ __('frontend.You may also like') }}</h4>
                                <div class="article__entry-carousel-three">
                                    @foreach ($relatedPosts as $post)
                                        <div class="item">
                                            <!-- Post Article -->
                                            <div class="article__entry">
                                                <div class="article__image">
                                                    <a href="{{ route('news-detail', $post->slug) }}">
                                                        <img src="{{ asset($post->image) }}" alt=""
                                                            class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="article__content">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <span class="text-primary">
                                                                {{ __('frontend.By') }}
                                                                <a href="">{{ $post->author->name }}</a>
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span>
                                                                {{ date('d-m-Y', strtotime($post->created_at)) }}
                                                            </span>
                                                        </li>
                                                    </ul>
                                                    <h5>
                                                        <a href="{{ route('news-detail', $post->slug) }}">
                                                            {{ truncate($post->title) }}
                                                        </a>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="sticky-top">
                        <aside class="wrapper__list__article">
                            <div class="mb-4">
                                <div class="widget__form-search-bar">
                                    <form method="GET" action="{{ route('news') }}">
                                        <div class="row no-gutters">
                                            <div class="col">
                                                <input class="form-control border-secondary border-right-0 rounded-0"
                                                    value="" placeholder="{{ __('frontend.Search') }}"
                                                    name="search">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit"
                                                    class="btn btn-outline-secondary border-left-0 rounded-0 rounded-right">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <h4 class="border_section">{{ __('frontend.Recent News') }}</h4>
                            <div class="wrapper__list__article-small">
                                @foreach ($recentNews as $news)
                                    @if ($loop->index <= 2)
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
                                    @endif

                                    @if ($loop->index == 3)
                                        <!-- Post Article -->
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-detail', $news->slug) }}">
                                                    <img src="{{ asset($news->image) }}" alt=""
                                                        class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <div class="article__category">
                                                    {{ $news->category->name }}
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <span class="text-primary">
                                                            {{ __('frontend.By') }} {{ $news->author->name }}
                                                        </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span class="text-dark text-capitalize">
                                                            {{ date('d-m-Y', strtotime($news->created_at)) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                                <h5>
                                                    <a href="{{ route('news-detail', $news->slug) }}">
                                                        {{ truncate($news->title) }}
                                                    </a>
                                                </h5>
                                                <p>
                                                    {!! truncate($news->content, 100) !!}
                                                </p>
                                                <a href="{{ route('news-detail', $news->slug) }}"
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
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete').click(function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: __('frontend.Are you sure?'),
                    text: __("frontend.You won't be able to revert this!"),
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: __('frontend.Yes, delete it!')
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('news-comment-delete') }}",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: __('frontend.Deleted!'),
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else if (response.status === 'error') {
                                    Swal.fire({
                                        title: __('frontend.Error!'),
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
