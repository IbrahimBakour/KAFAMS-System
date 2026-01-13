@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Available Activities</h1>
        @if(auth()->user()->type === 'admin')
            <!-- Add button for admins to create a new quiz (unified form) -->
            <a href="{{ route('quizzes.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Quiz
            </a>
        @endif
    </div>

    <!-- Display Quizzes (New System) -->
    @if($quizzes->count() > 0)
        <div class="mb-5">
            <h3>Quizzes</h3>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Title</th>
                            <th>Subject</th>
                            <th>Difficulty</th>
                            <th>Questions</th>
                            @if(auth()->user()->type === 'admin')
                                <th>Status</th>
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->title }}</td>
                                <td>{{ $quiz->subject }}</td>
                                <td>
                                    <span class="badge badge-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }}">
                                        {{ $quiz->difficulty_level }}
                                    </span>
                                </td>
                                <td>{{ $quiz->questions->count() }}</td>
                                @if(auth()->user()->type === 'admin')
                                    <td>
                                        @if($quiz->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @else
                                    <td>
                                        <a href="{{ route('quizzes.start', $quiz->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-play"></i> Start Quiz
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Display Activities (Old System) -->
    @if($activities->count() > 0)
        <div>
            <h3>Activities (Legacy)</h3>
            <div class="table-responsive">
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
            </div>
        </div>
    @endif

    @if($quizzes->count() === 0 && $activities->count() === 0)
        <div class="alert alert-info">
            <p>No activities available at the moment. @if(auth()->user()->type === 'admin') <a href="{{ route('quizzes.create') }}">Create your first quiz</a>.@endif</p>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
