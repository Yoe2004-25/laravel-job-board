@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Jobs</h5>
                <p class="card-text display-6">{{ auth()->user()->jobs->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Applications</h5>
                <p class="card-text display-6">{{ auth()->user()->applications->count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Companies</h5>
                <p class="card-text display-6">{{ auth()->user()->company ? 1 : 0 }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Notifications</h5>
                <p class="card-text display-6">{{ auth()->user()->unreadNotifications->count() }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Applications</h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->applications->count() > 0)
                    <ul class="list-group">
                        @foreach(auth()->user()->applications->take(5) as $application)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $application->title }}
                                <span class="badge {{ $application->status ? 'bg-success' : 'bg-warning' }}">
                                    {{ $application->status ? 'Approved' : 'Pending' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No applications yet.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Notifications</h5>
            </div>
            <div class="card-body">
                @if(auth()->user()->notifications->count() > 0)
                    <ul class="list-group">
                        @foreach(auth()->user()->notifications->take(5) as $notification)
                            <li class="list-group-item">
                                {{ $notification->data['message'] ?? 'Notification' }}
                                <small class="text-muted d-block">{{ $notification->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No notifications.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection