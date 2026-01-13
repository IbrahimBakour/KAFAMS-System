
@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fs-4">Student's Profile</h5>
                    <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-2 fw-bold" style="font-size: 1.25rem;">Name:</div>
                        <div class="col-md-10" style="font-size: 1.25rem;">{{ $profile->student_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 fw-bold" style="font-size: 1.25rem;">Gender:</div>
                        <div class="col-md-10" style="font-size: 1.25rem;">{{ $profile->gender }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 fw-bold" style="font-size: 1.25rem;">Address:</div>
                        <div class="col-md-10" style="font-size: 1.25rem;">{{ $profile->address }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 fw-bold" style="font-size: 1.25rem;">Parent's Name:</div>
                        <div class="col-md-10" style="font-size: 1.25rem;">{{ $profile->parent_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2 fw-bold" style="font-size: 1.25rem;">Contact No:</div>
                        <div class="col-md-10" style="font-size: 1.25rem;">{{ $profile->contact_no }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Student's Profile
                    <a href="{{ route('profile.edit', $profile->id) }}" class="btn btn-primary btn-sm float-end">
                        Edit
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">Name</div>
                        <div class="col-md-9">{{ $profile->student_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">Gender</div>
                        <div class="col-md-9">{{ $profile->gender }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">Address</div>
                        <div class="col-md-9">{{ $profile->address }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">Parent's Name</div>
                        <div class="col-md-9">{{ $profile->parent_name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">Contact No</div>
                        <div class="col-md-9">{{ $profile->contact_no }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h6>Student's Profile</h6>
                    //Edit Button at the top left of the container
                    <a href="{{ route('profile.edit', $profile->id) }}"><i class="fa fa-pencil-square-o"></i> Edit</a>
                    <div class="profile-container p-4">
                        <div class="profile-details">
                            <div class="mb-3">
                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</h6>
                                <p class="mb-0">{{$profile->student_name }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Gender</h6>
                                <p class="mb-0">{{$profile->gender }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</h6>
                                <p class="mb-0">{{ $profile->address }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Parent's Name</h6>
                                <p class="mb-0">{{$profile->parent_name }}</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact No</h6>
                                <p class="mb-0">{{$profile->contact_no }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection


