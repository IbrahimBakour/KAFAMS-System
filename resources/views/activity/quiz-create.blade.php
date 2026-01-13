@extends('layouts.mainAdmin-layout')

@section('content')
<div class="container">
    <h1>Create New Quiz</h1>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('quizzes.store') }}" method="POST" id="quizForm">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5>Quiz Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Quiz Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="subject">Subject <span class="text-danger">*</span></label>
                        <select class="form-control @error('subject') is-invalid @enderror"
                                id="subject" name="subject" required>
                            <option value="">Select Subject</option>
                            <option value="Adab" {{ old('subject') == 'Adab' ? 'selected' : '' }}>Adab</option>
                            <option value="Bahasa Arab" {{ old('subject') == 'Bahasa Arab' ? 'selected' : '' }}>Bahasa Arab</option>
                            <option value="Jawi" {{ old('subject') == 'Jawi' ? 'selected' : '' }}>Jawi</option>
                            <option value="Quran" {{ old('subject') == 'Quran' ? 'selected' : '' }}>Quran</option>
                            <option value="Tauhid" {{ old('subject') == 'Tauhid' ? 'selected' : '' }}>Tauhid</option>
                            <option value="Fiqh" {{ old('subject') == 'Fiqh' ? 'selected' : '' }}>Fiqh</option>
                        </select>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="difficulty_level">Difficulty Level <span class="text-danger">*</span></label>
                        <select class="form-control @error('difficulty_level') is-invalid @enderror"
                                id="difficulty_level" name="difficulty_level" required>
                            <option value="Easy" {{ old('difficulty_level') == 'Easy' ? 'selected' : '' }}>Easy</option>
                            <option value="Medium" {{ old('difficulty_level') == 'Medium' ? 'selected' : '' }} selected>Medium</option>
                            <option value="Hard" {{ old('difficulty_level') == 'Hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                        @error('difficulty_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Questions</h5>
                <button type="button" class="btn btn-sm btn-success" onclick="addQuestion()">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </div>
            <div class="card-body" id="questionsContainer">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Quiz</button>
            <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
let questionCounter = 0;

function addQuestion() {
    questionCounter++;
    const questionHtml = `
        <div class="question-block border rounded p-3 mb-3" id="question-${questionCounter}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Question ${questionCounter}</h6>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeQuestion(${questionCounter})">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>

            <div class="form-group">
                <label>Question Text <span class="text-danger">*</span></label>
                <textarea class="form-control" name="questions[${questionCounter}][question_text]" rows="2" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Option A <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${questionCounter}][option_a]" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Option B <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${questionCounter}][option_b]" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Option C <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${questionCounter}][option_c]" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Option D <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="questions[${questionCounter}][option_d]" required>
                </div>
            </div>

            <div class="form-group">
                <label>Correct Answer <span class="text-danger">*</span></label>
                <select class="form-control" name="questions[${questionCounter}][correct_option]" required>
                    <option value="">Select Correct Option</option>
                    <option value="A">Option A</option>
                    <option value="B">Option B</option>
                    <option value="C">Option C</option>
                    <option value="D">Option D</option>
                </select>
            </div>
        </div>
    `;

    document.getElementById('questionsContainer').insertAdjacentHTML('beforeend', questionHtml);
}

function removeQuestion(id) {
    document.getElementById(`question-${id}`).remove();
}

// Add one question by default when page loads
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
});
</script>
@endsection
