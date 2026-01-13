@php
    $layout = match (auth()->user()->type) {
        'admin' => 'layouts.mainAdmin-layout',
        'student' => 'layouts.main-layout',
    };
@endphp

@extends($layout)

@section('content')
<div class="container">
    <h1>Quiz for {{ $quiz->subject }}</h1>

    <!-- Show feedback message -->
    @if(session('message'))
        <div class="alert {{ session('message') === 'Correct answer! Well done!' ? 'alert-success' : 'alert-danger' }}">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('submit.quiz') }}" method="POST">
        @csrf
        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

        <div class="question">
            <p>{{ $quiz->question }}</p>
            <label><input type="radio" name="answer" value="A"> {{ $quiz->option_a }}</label><br>
            <label><input type="radio" name="answer" value="B"> {{ $quiz->option_b }}</label><br>
            <label><input type="radio" name="answer" value="C"> {{ $quiz->option_c }}</label><br>
            <label><input type="radio" name="answer" value="D"> {{ $quiz->option_d }}</label><br><br>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
