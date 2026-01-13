@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'parent' => 'layouts.mainParent-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h6>Edit Form</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <!-- Corrected Form -->
                            <form method="POST" action="{{ route('profile.update', ['id' => $profile->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')  <!-- Use the PUT method for updating the profile -->

                                <div style="margin-bottom: 15px;margin-left: 50px">
                                    <label style="display: block; margin-bottom: 5px;">Name</label>
                                    <input type="text" name="student_name" value="{{ $profile->student_name }}" placeholder="Name" style="width: 80%; padding: 4px;" />
                                </div>

                                <div style="margin-bottom: 15px;margin-left: 50px">
                                    <label style="display: block; margin-bottom: 5px;">Gender</label>
                                    <select class="form-select" name="gender" id="gender" aria-label="Default select example" style="width: 80%;">
                                        <option selected>Select</option>
                                        <option value="Male" {{ $profile->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $profile->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>

                                <div style="margin-bottom: 15px; margin-left: 50px">
                                    <label style="display: block; margin-bottom: 5px;">Address</label>
                                    <input type="text" name="address" value="{{ $profile->address }}" placeholder="Address" style="width: 80%; padding: 4px;" />
                                </div>

                                <div style="margin-bottom: 15px; margin-left: 50px">
                                    <label style="display: block; margin-bottom: 5px;">Parent's Name</label>
                                    <input type="text" name="parent_name" value="{{ $profile->parent_name }}" placeholder="Parent's Name" style="width: 80%; padding: 4px;" />
                                </div>

                                <div style="margin-bottom: 15px; margin-left: 50px">
                                    <label style="display: block; margin-bottom: 5px;">Contact No</label>
                                    <input type="text" name="contact_no" value="{{ $profile->contact_no }}" placeholder="Contact No" style="width: 80%; padding: 4px;" />
                                </div>

                                <div style="margin-left: 50px">
                                    <button type="submit" style="background-color: #007bff; color: #fff; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px;">Save Details</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h6> Edit form</h6>
                </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <form method="post" action="{{route('profile.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div style="margin-bottom: 15px;margin-left: 50px">
                                <label style="display: block; margin-bottom: 5px;">Name</label>
                                <input type="text" name="student_name" value="{{ $profile->student_name }}" placeholder="Name" style="width: 80%; padding: 4px;" />
                            </div>
                            </div>
                            <div style="margin-bottom: 15px;margin-left: 50px">
                                <label style="display: block; margin-bottom: 5px;">Gender</label>
                                    <select class="form-select" name="gender" id="gender" aria-label="Default select example" style="width: 80%;">
                                        <option selected>Select</option>
                                        <option value="Male" {{ $profile->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $profile->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                            </div>
                            <div style="margin-bottom: 15px; margin-left: 50px">
                                <label style="display: block; margin-bottom: 5px;">Address</label>
                                <input type="text" name="address" value="{{ $profile->address }}" placeholder="Address" style="width: 80%; padding: 4px;" />
                            </div>
                            <div style="margin-bottom: 15px; margin-left: 50px">
                                <label style="display: block; margin-bottom: 5px;">Parent's Name</label>
                                <input type="text" name="parent_name" value="{{ $profile->parent_name }}" placeholder="Parent's Name" style="width: 80%; padding: 4px;" />
                            </div>
                            <div style="margin-bottom: 15px; margin-left: 50px">
                                <label style="display: block; margin-bottom: 5px;">Contact No</label>
                                <input type="text" name="contact_no" value="{{ $profile->contact_no }}" placeholder="Contact No" style="width: 80%; padding: 4px;" />
                            </div>
                            <div>
                            <form method="post" action="{{ route('profile.update', ['id' => $profile->id]) }}" enctype="multipart/form-data">
                            <button style="background-color: #007bff; color: #fff; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px;margin-left: 50px">Submit</button> //original
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> original-->
@endsection

