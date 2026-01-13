<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\StudentQuizResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display all quizzes for admin
     */
    public function index()
    {
        $quizzes = Quiz::with(['admin', 'questions'])->latest()->get();
        return view('activity.quiz-index', compact('quizzes'));
    }

    /**
     * Show form to create a new quiz
     */
    public function create()
    {
        return view('activity.quiz-create');
    }

    /**
     * Store a newly created quiz
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:Easy,Medium,Hard',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        DB::beginTransaction();
        try {
            // Create the quiz
            $quiz = Quiz::create([
                'title' => $request->title,
                'subject' => $request->subject,
                'description' => $request->description,
                'difficulty_level' => $request->difficulty_level,
                'admin_id' => Auth::id(),
                'is_active' => true,
            ]);

            // Create questions
            foreach ($request->questions as $index => $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_option' => $questionData['correct_option'],
                    'order' => $index + 1,
                ]);
            }

            DB::commit();
            return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create quiz: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display a specific quiz for viewing/editing
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['questions', 'admin']);
        return view('activity.quiz-show', compact('quiz'));
    }

    /**
     * Show form to edit quiz
     */
    public function edit(Quiz $quiz)
    {
        $quiz->load('questions');
        return view('activity.quiz-edit', compact('quiz'));
    }

    /**
     * Update an existing quiz
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'difficulty_level' => 'required|in:Easy,Medium,Hard',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        DB::beginTransaction();
        try {
            // Update quiz details
            $quiz->update([
                'title' => $request->title,
                'subject' => $request->subject,
                'description' => $request->description,
                'difficulty_level' => $request->difficulty_level,
            ]);

            // Delete existing questions
            $quiz->questions()->delete();

            // Create new questions
            foreach ($request->questions as $index => $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'option_a' => $questionData['option_a'],
                    'option_b' => $questionData['option_b'],
                    'option_c' => $questionData['option_c'],
                    'option_d' => $questionData['option_d'],
                    'correct_option' => $questionData['correct_option'],
                    'order' => $index + 1,
                ]);
            }

            DB::commit();
            return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update quiz: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete a quiz
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Show available quizzes for students
     */
    public function availableQuizzes()
    {
        $studentId = Auth::id();

        $quizzes = Quiz::where('is_active', true)
            ->with(['questions', 'responses' => function($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }])
            ->latest()
            ->get();

        return view('activity.quiz-student-list', compact('quizzes'));
    }

    /**
     * Start a quiz for student
     */
    public function startQuiz(Quiz $quiz)
    {
        $quiz->load('questions');

        // Check if student has already submitted this quiz
        $existingResponse = StudentQuizResponse::where('quiz_id', $quiz->id)
            ->where('student_id', Auth::id())
            ->where('status', 'submitted')
            ->first();

        if ($existingResponse) {
            return redirect()->route('quizzes.results', $quiz->id)
                ->with('info', 'You have already completed this quiz.');
        }

        return view('activity.quiz-student-attempt', compact('quiz'));
    }

    /**
     * Submit quiz answers
     */
    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $quiz->load('questions');
        $answers = $request->answers;
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        // Calculate score
        foreach ($quiz->questions as $question) {
            $studentAnswer = $answers[$question->id] ?? null;
            if ($studentAnswer && $studentAnswer === $question->correct_option) {
                $score++;
            }
        }

        // Save or update response
        $response = StudentQuizResponse::updateOrCreate(
            [
                'quiz_id' => $quiz->id,
                'student_id' => Auth::id(),
            ],
            [
                'answers' => $answers,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );

        return redirect()->route('quizzes.results', $quiz->id)
            ->with('success', 'Quiz submitted successfully!');
    }

    /**
     * View quiz results for student
     */
    public function viewResults(Quiz $quiz)
    {
        $response = StudentQuizResponse::where('quiz_id', $quiz->id)
            ->where('student_id', Auth::id())
            ->where('status', 'submitted')
            ->firstOrFail();

        $quiz->load('questions');

        return view('activity.quiz-student-results', compact('quiz', 'response'));
    }

    /**
     * Toggle quiz active status
     */
    public function toggleStatus(Quiz $quiz)
    {
        $quiz->update(['is_active' => !$quiz->is_active]);

        $status = $quiz->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Quiz {$status} successfully.");
    }
}
