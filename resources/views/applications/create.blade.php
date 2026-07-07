@extends('layouts.app')

@section('title', 'Create Application')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-paper-plane"></i> Submit Application</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Application Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">CV (PDF, DOC, DOCX) <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('cv') is-invalid @enderror" 
                               id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                        <small class="text-muted">Max size: 2MB</small>
                        @error('cv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Applicant <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id" required>
                            <option value="">Select Applicant</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', Auth::id()) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="job_id" class="form-label">Job <span class="text-danger">*</span></label>
                        <select class="form-select @error('job_id') is-invalid @enderror" 
                                id="job_id" name="job_id" required>
                            <option value="">Select Job</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}" {{ old('job_id', request('job_id')) == $job->id ? 'selected' : '' }}>
                                    {{ $job->name }} - {{ $job->location }}
                                </option>
                            @endforeach
                        </select>
                        @error('job_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror" 
                                   id="status" name="status" value="1" {{ old('status') ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Approve application</label>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('applications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection