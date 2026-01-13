@extends('layouts.main-layout')

@section('content')
<div class="container">
    <h1>Available Quizzes</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($quizzes->count() > 0)
        <div class="row">
            @foreach($quizzes as $quiz)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }} text-white">
                            <h5 class="mb-0">{{ $quiz->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Subject:</strong> {{ $quiz->subject }}</p>
                            <p><strong>Difficulty:</strong>
                                <span class="badge badge-{{ $quiz->difficulty_level === 'Easy' ? 'success' : ($quiz->difficulty_level === 'Medium' ? 'warning' : 'danger') }}">
                                    {{ $quiz->difficulty_level }}
                                </span>
                            </p>
                            <p><strong>Total Questions:</strong> {{ $quiz->questions->count() }}</p>

                            @if($quiz->description)
                                <p class="text-muted">{{ Str::limit($quiz->description, 100) }}</p>
                            @endif

                            @php
                                $response = $quiz->responses->first();
                            @endphp

                            @if($response)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Completed
                                    <p class="mb-0"><strong>Score:</strong> {{ $response->score }}/{{ $response->total_questions }} ({{ $response->percentage }}%)</p>
                                </div>
                                <a href="{{ route('quizzes.results', $quiz->id) }}" class="btn btn-info btn-block">
                                    <i class="fas fa-chart-bar"></i> View Results
                                </a>
                            @else
                                <a href="{{ route('quizzes.start', $quiz->id) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-play"></i> Start Quiz
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <p>No quizzes available at the moment. Please check back later.</p>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
