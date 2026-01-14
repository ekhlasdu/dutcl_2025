@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✅ Success:</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>⚠️ Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Page Header --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 text-primary">Unsold Players</h3>
                <p class="text-muted mb-0">List of unsold players with option to assign to a team for free</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    {{-- ✅ Players Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">Unsold Player List</h5>

            @if($unsold->isEmpty())
                <div class="alert alert-info">No unsold players available.</div>
            @else
                <div class="table-responsive">
                    <table id="unsoldTable" class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Player Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Player Type</th>
                                <th>Profile</th>
                                <th>Assign to Team</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unsold as $player)
                                @php
                                    $imagePath = $player->profile_image
                                        ? '/storage/profile_images/' . $player->profile_image
                                        : asset('images/demo-image.jpg');
                                @endphp

                                <tr>
                                    <td>{{ $player->user->name }}</td>
                                    <td>{{ $player->designation }}</td>
                                    <td>{{ $player->department }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $player->ptype == 'Pool' ? 'bg-success' : 'bg-info' }}">
                                            {{ $player->ptype ?? 'Not Set' }}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{{ $imagePath }}" 
                                            alt="Player" 
                                            class="rounded-circle border"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <form action="{{ route('auction.assign-free') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="player_detail_id" value="{{ $player->id }}">
                                            <div class="input-group input-group-sm">
                                                <select name="team_id" class="form-select">
                                                    <option value="">-- Select Team --</option>
                                                    @foreach($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-success btn-sm">Assign Free</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Include jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTables
            $('#unsoldTable').DataTable({
                searching: true,
                paging: true,
                ordering: true,
                columnDefs: [
                    { searchable: false, orderable: false, targets: [4, 5] } // Profile and Assign columns
                ],
                pageLength: 10,
                language: {
                    search: "Search Players:",
                    searchPlaceholder: "Enter name, designation, or department"
                }
            });
        });
    </script>
@endpush