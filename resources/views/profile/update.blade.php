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
                    <h6>Display Table Students</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Student Name
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Gender
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Parent's Name
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Contact No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profiles as $profile)
                                <tr>
                                    <td class="text-center text-dark">{{ $profile->student_name }}</td>
                                    <td class="text-center text-dark">{{ $profile->gender }}</td>
                                    <td class="text-center text-dark">{{ $profile->address }}</td>
                                    <td class="text-dark">{{ $profile->parent_name }}</td>
                                    <td class="text-dark">{{ $profile->contact_no }}</td>
                                    <td>
                                        <a href="{{ route('profile.show', $profile->id) }}" class="btn btn-primary">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                        <form method="post" action="{{ route('profile.destroy', $profile->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $profiles->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--<div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h6> Display Table Students</h6>
                </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Student Name </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Gender </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Address </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Parent's Name </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Contact No </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($profiles as $profiles)
                                    <tr>
                                    <td scope="row" class="text-center text-dark">{{ $profiles->student_name }}</td>
                                    <td scope="row" class="text-center text-dark">{{ $profiles->gender }}</td>
                                    <td scope="row" class="text-center text-dark">{{ $profiles->address }}</td>
                                    <td scope="row" class="text-dark">{{ $profiles->parent_name }}</td>
                                    <td scope="row" class="text-dark">{{ $profiles->contact_no }}</td>
                                        <td>
                                        //View Button
                                        <a href="{{route('profile.show', $profiles->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i> View</a>
                                            //Delete Button
                                            <form method="post" action="{{ route('profile.destroy', $profiles->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="delete"><i class="fa fa-trash">Delete</i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
@endsection
