<div class="card border border-primary">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.general-setting.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.Site Name') }}</label>
                <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror"
                    value="{{ $settings['site_name'] }}">
                @error('site_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('admin.Site Logo') }}</label>
                <br>
                <img src="{{ asset($settings['site_logo']) }}" alt="" class="img-fluid logo">
                <input type="file" name="site_logo" class="form-control @error('site_logo') is-invalid @enderror">
                @error('site_logo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>{{ __('admin.Site Favicon') }}</label>
                <br>
                <img src="{{ asset($settings['site_favicon']) }}" alt="" width="100">
                <input type="file" name="site_favicon"
                    class="form-control @error('site_favicon') is-invalid @enderror">
                @error('site_favicon')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
            </div>
        </form>
    </div>
</div>
