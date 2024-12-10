@extends('admin.layouts.master')

@section('title', __('admin.Edit News'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Edit News') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.news.index') }}">{{ __('admin.News') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Edit') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Edit News') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>{{ __('admin.Language') }}</label>
                            <select name="language" id="language"
                                class="form-control @error('language') is-invalid @enderror">
                                <option value="">--- {{ __('admin.Select') }} ---</option>
                                @foreach ($languages as $language)
                                    <option @if ($language->language === $news->language) selected @endif
                                        value="{{ $language->language }}">
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Category') }}</label>
                            <select name="category" id="category"
                                class="form-control @error('category') is-invalid @enderror">
                                <option value="">--- {{ __('admin.Select') }} ---</option>
                                @foreach ($categories as $category)
                                    <option @if ($category->id === $news->category_id) selected @endif value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Image') }}</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">{{ __('admin.Choose File') }}</label>
                                <input type="file" name="image" id="image-upload" />
                            </div>
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Title') }}</label>
                            <input type="text" name="title" value="{{ $news->title }}"
                                class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Content') }}</label>
                            <textarea name="content" class="summernote">{{ $news->content }}</textarea>
                            @error('content')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Tags') }}</label>
                            <input type="text" name="tags" class="form-control inputtags"
                                value="{{ formatTags($news->tags()->pluck('name')->toArray()) }}">
                            @error('tags')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Meta Title') }}</label>
                            <input type="text" name="meta_title" value="{{ $news->meta_title }}"
                                class="form-control @error('meta_title') is-invalid @enderror">
                            @error('meta_title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>{{ __('admin.Meta Description') }}</label>
                            <input type="text" name="meta_description" value="{{ $news->meta_description }}"
                                class="form-control @error('meta_description') is-invalid @enderror">
                            @error('meta_description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            @if (canAccess('news status') || canAccess('news all-access'))
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('admin.Is Breaking News') }}?</div>
                                        <label class="custom-switch mt-2">
                                            <input @if ($news->is_breaking_news === 1) checked @endif type="checkbox"
                                                value="1" name="is_breaking_news" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('admin.Show at Slider') }}?</div>
                                        <label class="custom-switch mt-2">
                                            <input @if ($news->show_at_slider === 1) checked @endif type="checkbox"
                                                value="1" name="show_at_slider" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="control-label">{{ __('admin.Show at Popular') }}?</div>
                                        <label class="custom-switch mt-2">
                                            <input @if ($news->show_at_popular === 1) checked @endif type="checkbox"
                                                value="1" name="show_at_popular" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="control-label">{{ __('admin.Status') }}</div>
                                    <label class="custom-switch mt-2">
                                        <input @if ($news->status === 1) checked @endif type="checkbox"
                                            value="1" name="status" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#language').change(function() {
                const lang = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.fetch-news-category') }}",
                    data: {
                        language: lang
                    },
                    success: function(data) {
                        $('#category').html("");
                        $('#category').html(
                            `<option>--- {{ __('admin.Select') }} ---</option>`);

                        $.each(data, function(index, data) {
                            $('#category').append(
                                `<option value="${data.id}">${data.name}</option>`
                            );
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.image-preview').css({
                'background-image': 'url({{ asset($news->image) }})',
                "background-size": 'cover',
                'background-position': 'center center'
            });
        });
    </script>
@endpush
