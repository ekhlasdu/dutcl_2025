@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Team Header --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 text-primary">{{ $team->name }}</h3>
                <p class="text-muted mb-0">Team Details & Player List</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    {{-- ✅ Players Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">Players Bought by {{ $team->name }}</h5>

            @if($players->isEmpty())
                <div class="alert alert-info">No players have been bought by this team yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Player Name</th>
                                <th>Designation</th>
                                <th>Department</th>
                                <th>Player Type</th>
                                <th>Buying Amount</th>
                                <th>Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $auction)
                                @php
                                    $player = $auction->playerDetail;
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
                                            {{ ucfirst($player->ptype) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($auction->amount, 0) }}</td>
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