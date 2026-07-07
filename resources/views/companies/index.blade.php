@extends('layouts.app')

@section('title', 'Companies')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-building"></i> Companies</h1>
    @auth
        <a href="{{ route('companies.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Company
        </a>
    @endauth
</div>

@if($companies->count() > 0)
    <div class="row">
        @foreach($companies as $company)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('companies.show', $company->id) }}" class="text-decoration-none text-dark">
                                {{ $company->name }}
                            </a>
                        </h5>
                        <div class="company-info">
                            <p class="mb-1">
                                <i class="fas fa-users text-primary"></i> 
                                {{ $company->number_employees ?? 'N/A' }} employees
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-globe text-info"></i> 
                                {{ $company->website_name ?? 'N/A' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-phone text-success"></i> 
                                {{ $company->number_phone ?? 'N/A' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-user text-warning"></i> 
                                Manager: {{ $company->user->name ?? 'N/A' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-briefcase text-primary"></i> 
                                Jobs: {{ $company->jobs->count() }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        @auth
                            @if(Auth::id() == $company->user_id)
                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center">
        {{ $companies->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-building fa-3x text-muted mb-3"></i>
        <h4>No companies found</h4>
        <p class="text-muted">Start by adding your first company.</p>
        @auth
            <a href="{{ route('companies.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Company
            </a>
        @endauth
    </div>
@endif
@endsection