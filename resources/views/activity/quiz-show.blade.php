@extends('layouts.mainAdmin-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quiz Details</h1>
        <div>
            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Quiz
            </a>
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Quiz Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Title:</strong> {{ $quiz->title }}</p>
                    <p><strong>Subject:</strong> {{ $quiz->subject }}</p>
                    <p><strong>Difficulty:</strong>
                        <span class="badge badge-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }}">
                            {{ $quiz->difficulty_level }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        @if($quiz->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </p>
                    <p><strong>Created By:</strong> {{ $quiz->admin->name }}</p>
                    <p><strong>Total Questions:</strong> {{ $quiz->questions->count() }}</p>
                </div>
            </div>
            @if($quiz->description)
                <p><strong>Description:</strong></p>
                <p>{{ $quiz->description }}</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Questions ({{ $quiz->questions->count() }})</h5>
        </div>
        <div class="card-body">
            @foreach($quiz->questions as $index => $question)
                <div class="question-block border rounded p-3 mb-3">
                    <h6 class="text-primary">Question {{ $index + 1 }}</h6>
                    <p class="mb-2"><strong>{{ $question->question_text }}</strong></p>

                    <div class="options ml-3">
                        <p class="{{ $question->correct_option === 'A' ? 'text-success font-weight-bold' : '' }}">
                            A) {{ $question->option_a }}
                            @if($question->correct_option === 'A')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>
                        <p class="{{ $question->correct_option === 'B' ? 'text-success font-weight-bold' : '' }}">
                            B) {{ $question->option_b }}
                            @if($question->correct_option === 'B')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>
                        <p class="{{ $question->correct_option === 'C' ? 'text-success font-weight-bold' : '' }}">
                            C) {{ $question->option_c }}
                            @if($question->correct_option === 'C')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>
                        <p class="{{ $question->correct_option === 'D' ? 'text-success font-weight-bold' : '' }}">
                            D) {{ $question->option_d }}
                            @if($question->correct_option === 'D')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
