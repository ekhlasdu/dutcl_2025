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

            @if($id==1)
            <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <h4 class="mb-0 fw-bold">Team Owner</h4>
                <img src="https://ssl.du.ac.bd/fontView/assets/faculty_image/image_1307_new.jpg" {{-- Replace with $team->logo or similar --}}
                     alt="Team Image" 
                     class="rounded-circle shadow-sm border border-4 border-white"
                     style="width: 200px;  object-fit: cover;">
            </div>
            <div class="mt-2">
                
                
                <div class="text-secondary">
                    
                    <strong style="color:black"> Dr. Mohammad Siddiqur Rahman Khan</strong> <br>
                    <strong style="color:black; font-style:italic">Dean, Faculty of Arts</strong>
                </div>
            </div>
            @endif

            @if($id==2)
            <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <h4 class="mb-0 fw-bold">Team Owner</h4>
                <img src="https://www.bou.ac.bd/fontend/images/authority/vc_bou.jpg" {{-- Replace with $team->logo or similar --}}
                     alt="Team Image" 
                     class="rounded-circle shadow-sm border border-4 border-white"
                     style="width: 200px;  object-fit: cover;">
            </div>
            <div class="mt-2">
                
                
                <div class="text-secondary">
                    
                    <strong style="color:black">  Dr. A. B. M. Obaidul Islam </strong> <br>
                    <strong style="color:black; font-style:italic">Vice Chancellor, Bangladesh Open University</strong>
                </div>
            </div>
            @endif

            @if($id==3)
            <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <h4 class="mb-0 fw-bold">Team Owner</h4>
                <img src="https://ssl.du.ac.bd/fontView/assets/deans_image/deans_picture_FACSCI-1725434506.jpg" {{-- Replace with $team->logo or similar --}}
                     alt="Team Image" 
                     class="rounded-circle shadow-sm border border-4 border-white"
                     style="width: 200px;  object-fit: cover;">
            </div>
            <div class="mt-2">
                
                
                <div class="text-secondary">
                    
                    <strong style="color:black">  Dr.  Abdus Salam</strong> <br>
                    <strong style="color:black; font-style:italic">Dean, Faculty of Science</strong>
                </div>
            </div>
            @endif

            @if($id==4)
            <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <h4 class="mb-0 fw-bold">Team Owner</h4>
                <img src="https://ssl.du.ac.bd/fontView/assets/faculty_image/image_1013_new.jpeg" {{-- Replace with $team->logo or similar --}}
                     alt="Team Image" 
                     class="rounded-circle shadow-sm border border-4 border-white"
                     style="width: 200px;  object-fit: cover;">
            </div>
            <div class="mt-2">
                
                
                <div class="text-secondary">
                    
                    <strong style="color:black"> Dr. Md. Morshed Hasan Khan</strong> <br>
                    <strong style="color:black; font-style:italic">Professor, Department of Marketing</strong>
                </div>
            </div>
            @endif


        </div>

        <hr class="my-4 opacity-25">

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
                                <!-- <th>Buying Amount</th> -->
                                <th>Profile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($players as $auction)
                                @php
                                    $player = $auction->playerDetail;
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
                                            {{ ucfirst($player->ptype) }}
                                        </span>
                                    </td>
                                    <!-- <td>{{ number_format($auction->amount, 0) }}</td> -->
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