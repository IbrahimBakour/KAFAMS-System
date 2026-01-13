@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container">
    <h1>Available Activities</h1>

    @if(auth()->user()->type === 'admin')
        <!-- Add button for admins to create a new quiz -->
        <div class="mb-3">
            <a href="{{ route('activities.create') }}" class="btn btn-success">Add New Quiz</a>
        </div>
    @endif

    <!-- Check if there are activities -->
    @if($activities->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Level</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->subject }}</td>
                        <td>{{ $activity->level }}</td>
                        <td>
                            @if(auth()->user()->type === 'admin')
                                <!-- Edit and Delete buttons for admins -->
                                <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this activity?')">Delete</button>
                                </form>
                            @else
                                <!-- Take Quiz button for students -->
                                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-primary btn-sm">Take Quiz</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No activities available at the moment.</p>
    @endif
</div>
@endsection
