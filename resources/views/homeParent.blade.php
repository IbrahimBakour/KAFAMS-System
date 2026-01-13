@extends('layouts.main-layout')

@section('content')
<div class="container">
    <h1>Parent Dashboard</h1>
    <div class="alert alert-info">
        <p>Welcome to the KAFA Management System Parent Dashboard.</p>
        <p>Here you can monitor your child's academic progress and activities.</p>
    </div>

    <!-- Placeholder for future parent-specific features -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Student Profile</h5>
                    <p class="card-text">View your child's profile information.</p>
                    <a href="{{ route('profile.index2') }}" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Assessment Results</h5>
                    <p class="card-text">Check your child's test results and performance.</p>
                    <a href="{{ route('results.index') }}" class="btn btn-primary">View Results</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">KAFA Bulletin</h5>
                    <p class="card-text">Read latest announcements and news.</p>
                    <a href="{{ route('bulletin.indexBulletin') }}" class="btn btn-primary">View Bulletin</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
