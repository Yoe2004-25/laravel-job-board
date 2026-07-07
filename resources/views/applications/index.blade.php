@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-paper-plane"></i> Job Applications</h1>
    @auth
        <a href="{{ route('applications.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> New Application
        </a>
    @endauth
</div>

@if($applications->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job</th>
                    <th>Applicant</th>
                    <th>Title</th>
                    <th>CV</th>
                    <th>Status</th>
                    <th>Applied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>#{{ $application->id }}</td>
                        <td>
                            <a href="{{ route('jobs.show', $application->job_id) }}">
                                {{ $application->job->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td>{{ $application->user->name ?? 'N/A' }}</td>
                        <td>{{ $application->title }}</td>
                        <td>
                            @if($application->cv)
                                <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file-pdf"></i> View CV
                                </a>
                            @else
                                <span class="text-muted">No CV</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $application->status ? 'bg-success' : 'bg-warning' }}">
                                {{ $application->status ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td>{{ $application->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('applications.destroy', $application->id) }}" method="POST" 
                                  class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="d-flex justify-content-center">
        {{ $applications->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
        <h4>No applications found</h4>
        <p class="text-muted">Start applying for jobs or create your first application.</p>
        @auth
            <a href="{{ route('applications.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Create Application
            </a>
        @endauth
    </div>
@endif
@endsection