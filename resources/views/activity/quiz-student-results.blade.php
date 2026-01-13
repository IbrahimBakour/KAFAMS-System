@extends('layouts.main-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Quiz Results</h1>
        <a href="{{ route('student.quizzes') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quizzes
        </a>
    </div>

    <!-- Results Summary -->
    <div class="card mb-4">
        <div class="card-header bg-{{ $response->is_passed ? 'success' : 'danger' }} text-white">
            <h4 class="mb-0">
                @if($response->is_passed)
                    <i class="fas fa-check-circle"></i> Congratulations! You Passed!
                @else
                    <i class="fas fa-times-circle"></i> Quiz Completed
                @endif
            </h4>
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3">
                    <h3 class="text-primary">{{ $response->score }}</h3>
                    <p class="text-muted">Correct Answers</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-danger">{{ $response->total_questions - $response->score }}</h3>
                    <p class="text-muted">Wrong Answers</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-info">{{ $response->total_questions }}</h3>
                    <p class="text-muted">Total Questions</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-success">{{ $response->percentage }}%</h3>
                    <p class="text-muted">Score</p>
                </div>
            </div>

            <div class="progress" style="height: 30px;">
                <div class="progress-bar bg-{{ $response->is_passed ? 'success' : 'danger' }}"
                     role="progressbar"
                     style="width: {{ $response->percentage }}%;"
                     aria-valuenow="{{ $response->percentage }}"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    {{ $response->percentage }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Info -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Quiz Information</h5>
        </div>
        <div class="card-body">
            <p><strong>Quiz Title:</strong> {{ $quiz->title }}</p>
            <p><strong>Subject:</strong> {{ $quiz->subject }}</p>
            <p><strong>Difficulty:</strong>
                <span class="badge badge-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }}">
                    {{ $quiz->difficulty_level }}
                </span>
            </p>
            <p><strong>Submitted At:</strong> {{ $response->submitted_at->format('F j, Y, g:i a') }}</p>
        </div>
    </div>

    <!-- Detailed Answers -->
    <div class="card">
        <div class="card-header">
            <h5>Detailed Answers</h5>
        </div>
        <div class="card-body">
            @foreach($quiz->questions as $index => $question)
                @php
                    $studentAnswer = $response->answers[$question->id] ?? null;
                    $isCorrect = $studentAnswer === $question->correct_option;
                @endphp

                <div class="question-block border rounded p-3 mb-3 {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Question {{ $index + 1 }}</h6>
                        @if($isCorrect)
                            <span class="badge badge-success"><i class="fas fa-check"></i> Correct</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times"></i> Incorrect</span>
                        @endif
                    </div>

                    <p class="mb-2"><strong>{{ $question->question_text }}</strong></p>

                    <div class="options ml-3">
                        <p class="{{ $studentAnswer === 'A' ? ($question->correct_option === 'A' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($question->correct_option === 'A' ? 'text-success font-weight-bold' : '') }}">
                            A) {{ $question->option_a }}
                            @if($studentAnswer === 'A' && $question->correct_option === 'A')
                                <span class="badge badge-success">Your Correct Answer</span>
                            @elseif($studentAnswer === 'A')
                                <span class="badge badge-danger">Your Answer</span>
                            @elseif($question->correct_option === 'A')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>

                        <p class="{{ $studentAnswer === 'B' ? ($question->correct_option === 'B' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($question->correct_option === 'B' ? 'text-success font-weight-bold' : '') }}">
                            B) {{ $question->option_b }}
                            @if($studentAnswer === 'B' && $question->correct_option === 'B')
                                <span class="badge badge-success">Your Correct Answer</span>
                            @elseif($studentAnswer === 'B')
                                <span class="badge badge-danger">Your Answer</span>
                            @elseif($question->correct_option === 'B')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>

                        <p class="{{ $studentAnswer === 'C' ? ($question->correct_option === 'C' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($question->correct_option === 'C' ? 'text-success font-weight-bold' : '') }}">
                            C) {{ $question->option_c }}
                            @if($studentAnswer === 'C' && $question->correct_option === 'C')
                                <span class="badge badge-success">Your Correct Answer</span>
                            @elseif($studentAnswer === 'C')
                                <span class="badge badge-danger">Your Answer</span>
                            @elseif($question->correct_option === 'C')
                                <span class="badge badge-success">Correct Answer</span>
                            @endif
                        </p>

                        <p class="{{ $studentAnswer === 'D' ? ($question->correct_option === 'D' ? 'text-success font-weight-bold' : 'text-danger font-weight-bold') : ($question->correct_option === 'D' ? 'text-success font-weight-bold' : '') }}">
                            D) {{ $question->option_d }}
                            @if($studentAnswer === 'D' && $question->correct_option === 'D')
                                <span class="badge badge-success">Your Correct Answer</span>
                            @elseif($studentAnswer === 'D')
                                <span class="badge badge-danger">Your Answer</span>
                            @elseif($question->correct_option === 'D')
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
