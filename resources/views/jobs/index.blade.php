@extends('layouts.app')

@section('title', 'Job Listings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-list"></i> Job Listings</h1>
    @auth
        <a href="{{ route('jobs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Post New Job
        </a>
    @endauth
</div>

<!-- Search Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('jobs.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Search by title or description..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" 
                       placeholder="City, State..." value="{{ request('location') }}">
            </div>
            <div class="col-md-3">
                <label for="min_salary" class="form-label">Min Salary</label>
                <input type="number" class="form-control" id="min_salary" name="min_salary" 
                       placeholder="Min salary..." value="{{ request('min_salary') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Jobs List -->
@if($jobs->count() > 0)
    <div class="row">
        @foreach($jobs as $job)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-decoration-none text-dark">
                                {{ $job->name }}
                            </a>
                        </h5>
                        <p class="card-text text-muted">
                            {{ Str::limit($job->description, 120) }}
                        </p>
                        <div class="job-meta">
                            <p class="mb-1">
                                <i class="fas fa-building text-primary"></i> 
                                {{ $job->company->name ?? 'N/A' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-map-marker-alt text-danger"></i> 
                                {{ $job->location }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-dollar-sign text-success"></i> 
                                ${{ number_format($job->salary, 2) }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-user text-info"></i> 
                                Posted by: {{ $job->user->name ?? 'Unknown' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-clock text-warning"></i> 
                                {{ $job->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between">
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        @auth
                            <a href="#" class="btn btn-sm btn-success apply-btn" 
                               data-job-id="{{ $job->id }}" data-job-title="{{ $job->name }}">
                                <i class="fas fa-paper-plane"></i> Apply Now
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $jobs->withQueryString()->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h4>No jobs found</h4>
        <p class="text-muted">Try adjusting your search filters or post a new job.</p>
        @auth
            <a href="{{ route('jobs.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Post a Job
            </a>
        @endauth
    </div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Apply to job functionality
    document.querySelectorAll('.apply-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const jobId = this.dataset.jobId;
            const jobTitle = this.dataset.jobTitle;
            
            if (confirm(`Do you want to apply for "${jobTitle}"?`)) {
                window.location.href = `{{ route('applications.create') }}?job_id=${jobId}`;
            }
        });
    });
});
</script>
@endpush