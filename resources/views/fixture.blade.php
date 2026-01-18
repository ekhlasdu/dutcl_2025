@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- ✅ Page Header --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 text-primary">DUTCL II Fixtures</h3>
                <p class="text-muted mb-0">Match schedule for the tournament</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    {{-- ✅ Fixtures Table --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title mb-3">Schedule Details</h5>

            <div class="table-responsive">
                <table id="fixturesTable" class="table table-bordered align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th width="20%">Date & Day</th>
                            <th width="40%">Match 1 (9:00 AM)</th>
                            <th width="40%">Match 2 (12:30 PM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Row 1: 25/01/26 --}}
                        <tr>
                            <td class="fw-bold bg-light">
                                25/01/26 <br>
                                <span class="text-muted">[Sunday]</span>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">U-69</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">M-21</span>
                                </div>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">D-71</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">JJ</span>
                                </div>
                            </td>
                        </tr>

                        {{-- Row 2: 27/01/26 --}}
                        <tr>
                            <td class="fw-bold bg-light">
                                27/01/26 <br>
                                <span class="text-muted">[Tuesday]</span>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">U-69</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">JJ</span>
                                </div>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">D-71</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">M-21</span>
                                </div>
                            </td>
                        </tr>

                        {{-- Row 3: 29/01/26 --}}
                        <tr>
                            <td class="fw-bold bg-light">
                                29/01/26 <br>
                                <span class="text-muted">[Thursday]</span>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">M-21</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">JJ</span>
                                </div>
                            </td>
                            <td>
                                <div class="p-2">
                                    <span class="badge bg-dark px-3 py-2">D-71</span>
                                    <div class="my-1 fw-bold text-danger">vs</div>
                                    <span class="badge bg-dark px-3 py-2">U-69</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
            $('#fixturesTable').DataTable({
                searching: true,
                paging: false, // Turned off paging as it is a small fixture list
                ordering: false,
                info: false
            });
        });
    </script>
@endpush