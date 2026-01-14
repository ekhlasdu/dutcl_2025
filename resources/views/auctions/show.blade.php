@extends('layouts.app')

@section('content')
<div class="container py-4">

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

    <div class="row g-4">

        {{-- ✅ LEFT COLUMN - Player & Auction Form --}}
        <div class="col-lg-5">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3 rounded-top">
                    <h4 class="mb-0">Auction: {{ ucfirst($category) }} Player</h4>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        {{-- ✅ Profile Image --}}
                        <div class="me-3">
                            @php
                                $imagePath = $player->profile_image
                                    ? asset('storage/' . $player->profile_image)
                                    : asset('images/demo-image.jpg');
                            @endphp

                            <img src="{{ $imagePath }}" 
                                 alt="Player Image" 
                                 class="rounded-circle border border-2 border-primary shadow-sm"
                                 style="width: 110px; height: 110px; object-fit: cover;">
                        </div>

                        {{-- ✅ Player Info --}}
                        <div>
                            <h5 class="mb-1 text-primary fw-bold">{{ $player->user->name }}</h5>
                            <p class="mb-1"><strong>Department:</strong> {{ $player->department }}</p>
                            <p class="mb-1"><strong>Designation:</strong> {{ $player->designation }}</p>
                            <p class="mb-1"><strong>Base Price:</strong> ৳{{ number_format($basePrice) }}</p>
                        </div>
                    </div>

                    {{-- ✅ Auction Form --}}
                    <form method="POST" action="{{ url('auction/store') }}">
                        @csrf
                        <input type="hidden" name="player_detail_id" value="{{ $player->id }}">

                        <div class="mb-3">
                            <label for="team_id" class="form-label">Select Team</label>
                            <select name="team_id" id="team_id" class="form-select" required>
                                <option value="">-- Choose Team --</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Bid Amount (৳)</label>
                            <input type="number" name="amount" id="amount" class="form-control" min="{{ $basePrice }}" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                            💸 Submit Bid
                        </button>
                    </form>
                </div>

                {{-- ✅ Navigation Buttons --}}
                <div class="card-footer text-center bg-light">
                    @if($previous)
                        <a href="{{ url('operateAuction', ['category' => $category, 'playerId' => $previous->id]) }}" class="btn btn-outline-secondary me-2">
                            ⬅️ Previous
                        </a>
                    @endif

                    @if($next)
                        <a href="{{ url('operateAuction', ['category' => $category, 'playerId' => $next->id]) }}" class="btn btn-outline-primary">
                            Next ➡️
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- ✅ RIGHT COLUMN - Team Summary Table --}}
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0">🏏 Team Summary</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 align-middle">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>Team Name</th>
                                    <th>Pool Players</th>
                                    <th>Non-Pool Players</th>
                                    <th>Max Pool Bid (৳)</th>
                                    <th>Max Non-Pool Bid (৳)</th>
                                    <th>Remaining (৳)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($teamSummaries as $summary)
                                    <tr>
                                        <td class="fw-bold text-start ps-4"><a href="{{url('teamPlayer/'.$summary['team_id'])}}">{{ $summary['team_name'] }}</a> </td>
                                        <td>{{ $summary['pool_players'] }}</td>
                                        <td>{{ $summary['non_pool_players'] }}</td>
                                        <td class="text-success fw-semibold">{{ number_format($summary['max_pool_bid']) }}</td>
                                        <td class="text-info fw-semibold">{{ number_format($summary['max_non_pool_bid']) }}</td>
                                        <td class="text-danger fw-bold">{{ number_format($summary['remaining_amount']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer text-muted text-center">
                    <small>Each team’s total budget: ৳50,000</small>
                </div>
            </div>
        </div>

    </div> {{-- END ROW --}}
</div>
@endsection
