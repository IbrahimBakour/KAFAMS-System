@extends('layouts.main-layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $quiz->title }}</h1>
        <a href="{{ route('student.quizzes') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Quizzes
        </a>
    </div>

    <div class="alert alert-info">
        <p class="mb-0"><strong>Subject:</strong> {{ $quiz->subject }} |
           <strong>Questions:</strong> {{ $quiz->questions->count() }} |
           <strong>Difficulty:</strong> {{ $quiz->difficulty_level }}</p>
        @if($quiz->description)
            <p class="mt-2 mb-0">{{ $quiz->description }}</p>
        @endif
    </div>

    <form action="{{ route('quizzes.submit', $quiz->id) }}" method="POST" id="quizForm">
        @csrf

        @foreach($quiz->questions as $index => $question)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Question {{ $index + 1 }} of {{ $quiz->questions->count() }}</h5>
                </div>
                <div class="card-body">
                    <p class="lead">{{ $question->question_text }}</p>

                    <div class="form-group">
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio"
                                   class="custom-control-input"
                                   id="q{{ $question->id }}_a"
                                   name="answers[{{ $question->id }}]"
                                   value="A"
                                   required>
                            <label class="custom-control-label" for="q{{ $question->id }}_a">
                                A) {{ $question->option_a }}
                            </label>
                        </div>

                        <div class="custom-control custom-radio mb-2">
                            <input type="radio"
                                   class="custom-control-input"
                                   id="q{{ $question->id }}_b"
                                   name="answers[{{ $question->id }}]"
                                   value="B"
                                   required>
                            <label class="custom-control-label" for="q{{ $question->id }}_b">
                                B) {{ $question->option_b }}
                            </label>
                        </div>

                        <div class="custom-control custom-radio mb-2">
                            <input type="radio"
                                   class="custom-control-input"
                                   id="q{{ $question->id }}_c"
                                   name="answers[{{ $question->id }}]"
                                   value="C"
                                   required>
                            <label class="custom-control-label" for="q{{ $question->id }}_c">
                                C) {{ $question->option_c }}
                            </label>
                        </div>

                        <div class="custom-control custom-radio mb-2">
                            <input type="radio"
                                   class="custom-control-input"
                                   id="q{{ $question->id }}_d"
                                   name="answers[{{ $question->id }}]"
                                   value="D"
                                   required>
                            <label class="custom-control-label" for="q{{ $question->id }}_d">
                                D) {{ $question->option_d }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="card bg-light mb-4">
            <div class="card-body">
                <h5>Ready to Submit?</h5>
                <p>Make sure you have answered all questions before submitting.</p>
                <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Are you sure you want to submit your answers? You cannot change them after submission.')">
                    <i class="fas fa-check"></i> Submit Quiz
                </button>
            </div>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
// Track answered questions
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        updateProgress();
    });
});

function updateProgress() {
    const totalQuestions = {{ $quiz->questions->count() }};
    const answeredQuestions = new Set();

    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
        const questionId = input.name.match(/\[(.*?)\]/)[1];
        answeredQuestions.add(questionId);
    });

    console.log(`Answered: ${answeredQuestions.size}/${totalQuestions}`);
}
</script>
@endsection
