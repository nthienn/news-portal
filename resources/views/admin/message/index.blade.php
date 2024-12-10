@extends('admin.layouts.master')

@section('title', __('admin.Message'))

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Message') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{ route('admin.dashboard') }}">{{ __('admin.Dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ __('admin.Message') }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('admin.Message') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ __('admin.Email') }}</th>
                                    <th>{{ __('admin.Subject') }}</th>
                                    <th>{{ __('admin.Message') }}</th>
                                    <th>{{ __('admin.Replied') }}</th>
                                    <th>{{ __('admin.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $key => $message)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ $message->message }}</td>
                                        <td>
                                            @if ($message->replied == 1)
                                                <div class="badge badge-success"><i class="fas fa-check"></i></div>
                                            @else
                                                <div class="badge badge-warning"><i class="fas fa-clock"></i></div>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-info" data-toggle="modal"
                                                data-target="#exampleModal-{{ $message->id }}">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <a href="{{ route('admin.message.destroy', $message->id) }}"
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

    @foreach ($messages as $key => $message)
        <!-- Modal -->
        <div class="modal fade" id="exampleModal-{{ $message->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.Reply to') }}: {{ $message->email }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.message.reply') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="email" class="form-control" value="{{ $message->email }}">
                                <input type="hidden" name="message_id" class="form-control" value="{{ $message->id }}">
                                <label>{{ __('admin.Subject') }}</label>
                                <input type="text" name="subject"
                                    class="form-control @error('subject') is-invalid @enderror">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>{{ __('admin.Message') }}</label>
                                <textarea name="message" class="form-control" style="height: 200px !important"></textarea>
                                @error('message')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('admin.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('admin.Send') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
