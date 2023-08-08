@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Notifications
                        </h4>
                        <a href="{{ route('investigator.notifications.mark-all-read') }}"
                           class="btn btn-link float-end">
                            Mark all as read
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($notifications->count())
                                <div class="list-group">
                                    @foreach($notifications as $notification)
                                        <div
                                            class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'active' }}">
                                            <div class="d-flex w-100 justify-content-between">
                                                <a href="{{ route('investigator.notifications.show', $notification->id) }}">
                                                    <h5 class="mb-1">{{ $notification->title }}</h5>
                                                </a>

                                                <a href="{{ route('investigator.notifications.show', $notification->id) }}"
                                                   class="text-dark">
                                                    <small>
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </small>
                                                </a>
                                            </div>
                                            <p class="mb-1">
                                                <a href="{{ route('investigator.notifications.show', $notification->id) }}"
                                                   class="text-dark font-weight-bold">
                                                    {{ $notification->message }}
                                                </a>

                                                <a href="{{ route('investigator.notifications.destroy', $notification->id) }}"
                                                   class="float-end text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center">No notifications found!</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
