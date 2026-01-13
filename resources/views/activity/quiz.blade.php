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

    @if(auth()->user()->type === 'student')
        <!-- Display the student's own results -->
        <h2>Your Marks</h2>
        <p>Score: {{ $quiz->score }}</p>
        <!-- Optionally, you can display more details like correct answers, etc. -->
    @elseif(auth()->user()->type === 'admin')
        <!-- Admin can see quiz details, student name, and their score -->
        <h2>Quiz Results</h2>
        <p>Student: {{ $quiz->student->name }}</p>
        <p>Score: {{ $quiz->score }}</p>
    @else
        <p>Unauthorized access!</p>
    @endif
</div>
@endsection

