@extends('layouts.app')

@section('title', 'Add Company')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-plus"></i> Add New Company</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="number_employees" class="form-label">Number of Employees</label>
                            <input type="number" class="form-control @error('number_employees') is-invalid @enderror" 
                                   id="number_employees" name="number_employees" value="{{ old('number_employees') }}">
                            @error('number_employees')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="website_name" class="form-label">Website</label>
                            <input type="text" class="form-control @error('website_name') is-invalid @enderror" 
                                   id="website_name" name="website_name" value="{{ old('website_name') }}" 
                                   placeholder="example.com">
                            @error('website_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="number_phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('number_phone') is-invalid @enderror" 
                               id="number_phone" name="number_phone" value="{{ old('number_phone') }}" 
                               placeholder="+1234567890">
                        @error('number_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Manager <span class="text-danger">*</span></label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id" required>
                            <option value="">Select Manager</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('companies.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Create Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection