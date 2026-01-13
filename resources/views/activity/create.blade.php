@extends('layouts.mainAdmin-layout')

@section('content')
<div class="container">
    <h1>Create New Quiz</h1>
    <form action="{{ route('activities.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="text" name="level" id="level" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <textarea name="question" id="question" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="option_a" class="form-label">Option A</label>
            <input type="text" name="option_a" id="option_a" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="option_b" class="form-label">Option B</label>
            <input type="text" name="option_b" id="option_b" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="option_c" class="form-label">Option C</label>
            <input type="text" name="option_c" id="option_c" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="option_d" class="form-label">Option D</label>
            <input type="text" name="option_d" id="option_d" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
