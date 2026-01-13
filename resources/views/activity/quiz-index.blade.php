@extends('layouts.mainAdmin-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quiz Management</h1>
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Quiz
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($quizzes->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Difficulty</th>
                        <th>Questions</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->id }}</td>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ $quiz->subject }}</td>
                            <td>
                                <span class="badge badge-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }}">
                                    {{ $quiz->difficulty_level }}
                                </span>
                            </td>
                            <td>{{ $quiz->questions->count() }}</td>
                            <td>
                                @if($quiz->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $quiz->admin->name }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('quizzes.toggleStatus', $quiz->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $quiz->is_active ? 'secondary' : 'success' }}" title="{{ $quiz->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <p>No quizzes found. <a href="{{ route('quizzes.create') }}">Create your first quiz</a>.</p>
        </div>
    @endif
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
