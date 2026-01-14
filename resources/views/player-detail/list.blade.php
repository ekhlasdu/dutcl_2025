@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Page Header --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 text-primary">All Players</h3>
                <p class="text-muted mb-0">List of all players with editable player type (Pool/Non-Pool)</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    {{-- ✅ Players Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">Player List</h5>

            @if($players->isEmpty())
                <div class="alert alert-info">No players available.</div>
            @else
                <div class="table-responsive">
                    <table id="playersTable" class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Player Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Player Type</th>
                                <th>Profile</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $player)
                                @php
                                    $imagePath = $player->profile_image
                                        ? asset('storage/' . $player->profile_image)
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
                                        <form action="{{ route('players.update-ptype', $player->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <select name="ptype" class="form-select">
                                                    <option value="Pool" {{ $player->ptype == 'Pool' ? 'selected' : '' }}>Pool</option>
                                                    <option value="Non-Pool" {{ $player->ptype == 'Non-Pool' ? 'selected' : '' }}>Non-Pool</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
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
            $('#playersTable').DataTable({
                // Enable search, pagination, and sorting
                searching: true,
                paging: true,
                ordering: true,
                // Disable searching on the Profile and Actions columns
                columnDefs: [
                    { searchable: false, orderable: false, targets: [4, 5] } // Profile (image) and Actions columns
                ],
                // Optional: Customize the number of entries per page
                pageLength: 10,
                // Optional: Customize the language for the search bar
                language: {
                    search: "Search Players:",
                    searchPlaceholder: "Enter name, designation, or department"
                }
            });
        });
    </script>
@endpush