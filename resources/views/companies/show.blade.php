@extends('layouts.app')

@section('title', $company->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>{{ $company->name }}</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><i class="fas fa-users text-primary"></i> <strong>Employees:</strong> {{ $company->number_employees ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-globe text-info"></i> <strong>Website:</strong> {{ $company->website_name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><i class="fas fa-phone text-success"></i> <strong>Phone:</strong> {{ $company->number_phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><i class="fas fa-user text-warning"></i> <strong>Manager:</strong> {{ $company->user->name ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <hr>
                
                <h5>Jobs at {{ $company->name }}</h5>
                @if($company->jobs->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Job Title</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Posted</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($company->jobs as $job)
                                    <tr>
                                        <td>{{ $job->name }}</td>
                                        <td>{{ $job->location }}</td>
                                        <td>${{ number_format($job->salary, 2) }}</td>
                                        <td>{{ $job->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No jobs posted by this company yet.</p>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('companies.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Companies
                    </a>
                    @auth
                        @if(Auth::id() == $company->user_id)
                            <div>
                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
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
                    @if(Auth::id() == $company->user_id)
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning w-100 mb-2">
                            <i class="fas fa-edit"></i> Edit Company
                        </a>
                    @endif
                    <a href="{{ route('jobs.create') }}?company_id={{ $company->id }}" class="btn btn-success w-100">
                        <i class="fas fa-plus"></i> Post Job for this Company
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection