@extends('layouts.app')

@section('content')
<div class="container">
    <h3>No more {{ ucfirst($category) }} players available for auction.</h3>
    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go Back to Dashboard</a>
</div>
@endsection