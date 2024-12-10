<div class="card border border-primary">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.seo-setting.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.Site SEO Title') }}</label>
                <input type="text" name="site_seo_title"
                    class="form-control @error('site_seo_title') is-invalid @enderror"
                    value="{{ $settings['site_seo_title'] }}">
                @error('site_seo_title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('admin.Site SEO Description') }}</label>
                <textarea name="site_seo_description" class="form-control">{{ $settings['site_seo_description'] }}</textarea>
                @error('site_seo_description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('admin.Site SEO Keywords') }}</label>
                <input type="text" name="site_seo_keywords" class="form-control inputtags"
                    value="{{ $settings['site_seo_keywords'] }}">
                @error('site_seo_keywords')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
            </div>
        </form>
    </div>
</div>
