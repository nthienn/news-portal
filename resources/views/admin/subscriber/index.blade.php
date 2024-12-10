@extends('admin.layouts.master')

@section('title', __('admin.Subscriber'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Subscriber') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Subscriber') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Send mail to Subscribers') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscriber.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('admin.Subject') }}</label>
                            <input type="text" name="subject" value="{{ old('subject') }}"
                                class="form-control @error('subject') is-invalid @enderror">
                            @error('subject')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>{{ __('admin.Message') }}</label>
                            <textarea name="message" class="summernote">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">{{ __('admin.Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Subscriber') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('admin.ID') }}</th>
                                    <th>{{ __('admin.Email') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $key => $subscriber)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $subscriber->id }}</td>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>
                                            <a href="{{ route('admin.subscriber.destroy', $subscriber) }}"
                                                class="btn btn-danger delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
