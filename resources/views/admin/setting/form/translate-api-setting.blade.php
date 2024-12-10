<div class="card border border-primary">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.translate-api-setting.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.API Host') }}</label>
                <input type="text" name="site_api_host" class="form-control @error('api_host') is-invalid @enderror"
                    value="{{ $settings['site_api_host'] }}">
                @error('api_host')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('admin.API Key') }}</label>
                <input type="text" name="site_api_key" class="form-control @error('api_key') is-invalid @enderror"
                    value="{{ $settings['site_api_key'] }}">
                @error('api_key')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
            </div>
        </form>
    </div>
</div>
