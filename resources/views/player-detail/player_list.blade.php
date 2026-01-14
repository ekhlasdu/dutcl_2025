@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Page Header --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 text-primary">All Players</h3>
                <p class="text-muted mb-0">List of all players filtered by type (Pool/Non-Pool)</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    {{-- ✅ Filter Section --}}
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="text-muted mb-3 font-weight-bold">Quick Filter:</h6>
            <div class="d-flex gap-4">
                <div class="form-check">
                    <input class="form-check-input player-filter" type="radio" name="ptypeFilter" id="allPlayers" value="" checked>
                    <label class="form-check-label fw-bold" for="allPlayers">All Players</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input player-filter" type="radio" name="ptypeFilter" id="poolPlayers" value="Pool">
                    <label class="form-check-label fw-bold text-success" for="poolPlayers">Pool Players</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input player-filter" type="radio" name="ptypeFilter" id="nonPoolPlayers" value="Non-Pool">
                    <label class="form-check-label fw-bold text-info" for="nonPoolPlayers">Non-Pool Players</label>
                </div>
            </div>
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
                                <th>Availability</th>
                                <th>Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $player)
                                @php
                                    $imagePath = $player->profile_image
                                        ? '/storage/profile_images/' . $player->profile_image
                                        : asset('images/demo-image.jpg');
                                @endphp

                                <tr>
                                    <td>{{ $player->user->name ?? 'N/A' }}</td>
                                    <td>{{ $player->designation }}</td>
                                    <td>{{ $player->department }}</td>
                                    <td>
                                        <span class="badge {{ $player->ptype == 'Pool' ? 'bg-success' : 'bg-info' }}">
                                            {{ $player->ptype ?? 'Not Set' }}
                                        </span>
                                    </td>
                                    <td>{{ $player->availability }}</td>
                                    <td>
                                        <img src="{{ $imagePath }}" 
                                            alt="Player" 
                                            class="rounded-circle border"
                                            style="width: 60px; height: 60px; object-fit: cover;">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            // 1. Initialize the Table
            var table = $('#playersTable').DataTable({
                searching: true,
                paging: true,
                ordering: true,
                columnDefs: [
                    // Only column 4 (Profile Image) is now non-sortable
                    { searchable: false, orderable: false, targets: [4] } 
                ],
                pageLength: 10
            });

            // 2. Custom Filter Logic
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var selectedFilter = $('input[name="ptypeFilter"]:checked').val();
                    var columnValue = data[3].trim(); // Column 3 is still "Player Type"

                    if (selectedFilter === "") {
                        return true;
                    }
                    return columnValue === selectedFilter;
                }
            );

            // 3. Redraw table on radio change
            $('.player-filter').on('change', function() {
                table.draw();
            });
        });
    </script>
@endpush