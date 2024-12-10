<div class="card border border-primary">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.appearance-setting.update') }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.Pick Color') }}</label>
                <div class="input-group colorpickerinput">
                    <input type="text" name="site_color" class="form-control @error('site_color') is-invalid @enderror"
                        value="{{ $settings['site_color'] }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                        </div>
                    </div>
                    @error('site_color')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">{{ __('admin.Save') }}</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $('.colorpickerinput').colorpicker({
            format: 'hex',
            component: '.input-group-append'
        })
    </script>
@endpush
