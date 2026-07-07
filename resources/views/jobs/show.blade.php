@extends('layouts.app')

@section('title', $job->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>{{ $job->name }}</h4>
                <span class="badge bg-primary">{{ $job->created_at->diffForHumans() }}</span>
            </div>
            <div class="card-body">
                <div class="job-details">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><i class="fas fa-building text-primary"></i> <strong>Company:</strong> {{ $job->company->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-user text-info"></i> <strong>Posted By:</strong> {{ $job->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><i class="fas fa-dollar-sign text-success"></i> <strong>Salary:</strong> ${{ number_format($job->salary, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="fas fa-map-marker-alt text-danger"></i> <strong>Location:</strong> {{ $job->location }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5>Description</h5>
                    <p class="text-justify">{{ $job->description }}</p>
                    
                    <hr>
                    
                    <h5>Applications ({{ $job->applications->count() }})</h5>
                    @if($job->applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Applicant</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Applied</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job->applications as $application)
                                        <tr>
                                            <td>{{ $application->user->name ?? 'N/A' }}</td>
                                            <td>{{ $application->title }}</td>
                                            <td>
                                                <span class="badge {{ $application->status ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $application->status ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>{{ $application->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No applications yet.</p>
                    @endif
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Jobs
                    </a>
                    <div>
                        @auth
                            <a href="{{ route('applications.create') }}?job_id={{ $job->id }}" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Apply Now
                            </a>
                            @if(Auth::id() == $job->user_id)
                                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                @auth
                    <a href="{{ route('applications.create') }}?job_id={{ $job->id }}" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-paper-plane"></i> Apply for this Job
                    </a>
                @endauth
                @if(Auth::check() && Auth::id() == $job->user_id)
                    <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-edit"></i> Edit Job
                    </a>
                    <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Job
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5>Company Info</h5>
            </div>
            <div class="card-body">
                @if($job->company)
                    <h6>{{ $job->company->name }}</h6>
                    <p class="mb-1"><i class="fas fa-users"></i> {{ $job->company->number_employees ?? 'N/A' }} employees</p>
                    <p class="mb-1"><i class="fas fa-globe"></i> {{ $job->company->website_name ?? 'N/A' }}</p>
                    <p class="mb-0"><i class="fas fa-phone"></i> {{ $job->company->number_phone ?? 'N/A' }}</p>
                @else
                    <p class="text-muted">No company information available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection