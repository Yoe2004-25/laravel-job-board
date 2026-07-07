@extends('layouts.app')

@section('title', 'Application Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Application Details</h4>
                <span class="badge {{ $application->status ? 'bg-success' : 'bg-warning' }}">
                    {{ $application->status ? 'Approved' : 'Pending' }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Application Title:</strong> {{ $application->title }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Applied:</strong> {{ $application->created_at->format('F d, Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Job:</strong> 
                            <a href="{{ route('jobs.show', $application->job_id) }}">
                                {{ $application->job->name ?? 'N/A' }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Applicant:</strong> {{ $application->user->name ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p><strong>CV:</strong></p>
                        @if($application->cv)
                            <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i> Download CV
                            </a>
                            <a href="{{ asset('storage/' . $application->cv) }}" target="_blank" class="btn btn-info">
                                <i class="fas fa-eye"></i> View CV
                            </a>
                        @else
                            <p class="text-muted">No CV uploaded</p>
                        @endif
                    </div>
                </div>

                @if($application->job)
                    <hr>
                    <h5>Job Details</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Company:</strong> {{ $application->job->company->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Location:</strong> {{ $application->job->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Salary:</strong> ${{ number_format($application->job->salary ?? 0, 2) }}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Applications
                    </a>
                    <div>
                        <a href="{{ route('applications.edit', $application->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('applications.destroy', $application->id) }}" method="POST" 
                              class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection