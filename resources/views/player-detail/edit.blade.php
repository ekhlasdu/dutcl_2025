@extends('layouts.app')

@section('content')
<div class="container mt-5">
    
    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Form Start --}}
    <form method="POST" action="{{ url('dashboard_update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="department" class="form-label">Department/Institute</label>
            <select name="department" id="department" class="form-select @error('department') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach($departments as $id => $name)
                    <option value="{{ $name }}" {{ old('department', $playDetail->department) == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Designation --}}
        @php
            $designations = ['Lecturer', 'Assistant Professor', 'Associate Professor', 'Professor'];
        @endphp

        <div class="mb-3">
            <label for="designation" class="form-label">Designation</label>
            <select name="designation" id="designation" class="form-select @error('designation') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach($designations as $name)
                    <option value="{{ $name }}" {{ old('designation', $playDetail->designation) == $name ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('designation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Batting --}}
        <div class="mb-3">
            <label for="batting" class="form-label">Batting</label>
            <select name="batting" id="batting" class="form-select @error('batting') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach(['Just for Fun', 'Good', 'Excellent'] as $level)
                    <option value="{{ $level }}" {{ old('batting', $playDetail->batting) == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            @error('batting')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bowling --}}
        <div class="mb-3">
            <label for="bowling" class="form-label">Bowling</label>
            <select name="bowling" id="bowling" class="form-select @error('bowling') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach(['Just for Fun', 'Good', 'Excellent'] as $level)
                    <option value="{{ $level }}" {{ old('bowling', $playDetail->bowling) == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            @error('bowling')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Keeping --}}
        <div class="mb-3">
            <label for="keeping" class="form-label">Keeping</label>
            <select name="keeping" id="keeping" class="form-select @error('keeping') is-invalid @enderror">
                <option value="">-- Select --</option>
                @foreach(['Just for Fun', 'Good', 'Excellent'] as $level)
                    <option value="{{ $level }}" {{ old('keeping', $playDetail->keeping) == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
            </select>
            @error('keeping')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Played as Student --}}
        <div class="mb-3">
            <label class="form-label">Have you played as student?</label>
            <select name="played_as_student" class="form-select @error('played_as_student') is-invalid @enderror">
                <option value="Yes" {{ old('played_as_student', $playDetail->played_as_student) == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('played_as_student', $playDetail->played_as_student) == 'No' ? 'selected' : '' }}>No</option>
            </select>
            @error('played_as_student')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Played DUTCL --}}
        <div class="mb-3">
            <label class="form-label">Have you played in DUTCL?</label>
            <select name="played_dutcl" class="form-select @error('played_dutcl') is-invalid @enderror">
                <option value="Yes" {{ old('played_dutcl', $playDetail->played_dutcl) == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('played_dutcl', $playDetail->played_dutcl) == 'No' ? 'selected' : '' }}>No</option>
            </select>
            @error('played_dutcl')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Availability</label>
            <input type="text" name="availability" value="{{$playDetail->availability?$playDetail->availability:''}}"  class="form-control">
            ex: 25 January 2026, 27 January 2026, 29 January 2026, 31 January 2026
            @error('availability')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Unavailability</label>
            <input type="text" name="unavailability" value="{{$playDetail->unavailability?$playDetail->unavailability:''}}"  class="form-control">
            ex: 25 January 2026, 27 January 2026, 29 January 2026, 31 January 2026
            @error('unavailability')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ✅ Profile Image --}}
        <div class="mb-3">
            <label for="profile_image" class="form-label">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image"
                   class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">

            @if ($playDetail->profile_image)
                <div class="mt-3">
                    <img src="{{ Storage::url($playDetail->profile_image) }}" 
                        alt="Profile Image"
                        class="rounded border"
                        style="width: 120px; height: 120px; object-fit: cover;">
                    <div class="mt-2">
                        <a href="{{ route('player.removeImage') }}" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to remove this image?')">
                        Remove Image
                        </a>
                    </div>
                </div>
            @endif
            @error('profile_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Details</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('select').select2({
            placeholder: "-- Select --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
