@extends('website.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-5 d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Edit Lead Status</h4>
            <a href="{{ route('leads-status.index') }}" class="btn btn-secondary btn-wave float-end">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style2 mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);"><i class="bi bi-house-door me-1 fs-15"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('leads-status.index') }}"><i class="bi bi-clipboard me-1 fs-15"></i> Lead Status</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Lead Status</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12 mb-5 mt-3 bg-white p-5 shadow">
            <form action="{{ route('leads-status.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="bi bi-tag me-1"></i> Name <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $lead->name) }}" required>
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Field -->
                <div class="mb-3">
                    <label for="status" class="form-label">
                        <i class="bi bi-gear me-1"></i> Status <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-gear"></i></span>
                        <input type="text" name="status" id="status" class="form-control" value="{{ old('status', $lead->status) }}" required>
                    </div>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Category Dropdown -->
                <div class="mb-3">
                    <label for="category" class="form-label fw-bold">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="open" {{ old('category', $lead->category) == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ old('category', $lead->category) == 'closed' ? 'selected' : '' }}>Closed</option>
                        <option value="lost" {{ old('category', $lead->category) == 'lost' ? 'selected' : '' }}>Lost</option>
                        <option value="completed" {{ old('category', $lead->category) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> 
                <!-- Details Field -->
                <div class="mb-3">
                    <label for="details" class="form-label">
                        <i class="bi bi-info-circle me-1"></i> Details
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-info-circle"></i></span>
                        <textarea name="details" id="details" class="form-control">{{ old('details', $lead->details) }}</textarea>
                    </div>
                    @error('details')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Color Picker Field -->
                <div class="mb-3">
                    <label for="color" class="form-label">
                        <i class="bi bi-palette me-1"></i> Color <sup class="text-danger">*</sup>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-palette"></i></span>
                        <input type="color" name="color" id="color" class="form-control" value="{{ old('color', '#000000') }}" required>
                    </div>
                    @error('color')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-save me-1"></i> Update Lead Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
