<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\ResultQuiz;
use App\Models\TempQuiz;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {  
        $id_material = session('idMaterial');
        $idUser = Auth::user();
        $answers = session('quiz.answers', []);
        $question = session('quiz.questionn', []);
        $id_answer = [];
        foreach ($answers as $answer) {
            $id_answer[] = $answer['answer_id'];
        }
    
        $answerData = Answer::whereIn('id', $id_answer)->with('question')->get();
        // Ubah logika penyimpanan hasil quiz
        $resultQuiz = ResultQuiz::where('id_material', $id_material[0])
            ->where('id_user', $idUser->id)
            ->first();
    
        if (!$resultQuiz) {
            $totalQuestions = count($answers);
            $correctAnswers = collect($answers)->where('is_correct', true)->count();
            $score = $totalQuestions > 0 
                ? round(($correctAnswers / $totalQuestions) * 100, 2) 
                : 0;

            $resultQuiz = ResultQuiz::create([
                'id_material' => $id_material[0],
                'id_user' => $idUser->id,
                'totalQuestion' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
                'score' => $score,
                'questions' => $question,
                'resultAnswers' => $answerData
            ]);
        }

        $data = [
            'answers' => $answers,
            'totalQuestions' => $resultQuiz->totalQuestion,
            'correctAnswers' => $resultQuiz->correctAnswers,
            'answerData' => $answerData,
            'score' => $resultQuiz->score,
        ];
    
        // Hapus session yang tidak diperlukan
        session()->forget('quiz.questions');
        session()->forget('quiz.current');
        session()->forget('quiz.answers');
        session()->forget('idMaterial');
    
        return view('user.result', $data);
    }
    
    public function startQuiz($idQuestion)
    {
        // Hapus session sebelumnya
        session()->forget('quiz.questions');
        session()->forget('quiz.questionn');
        session()->forget('quiz.current');
        session()->forget('quiz.answers');
        session()->forget('idMaterial');
    
        $idMaterial = Question::where('id', $idQuestion)->pluck('id_material');
        $countQuestion = Question::whereIn('id_material', $idMaterial)->get();
    
        // Cek apakah quiz sudah pernah dikerjakan sebelumnya
        $existingResult = ResultQuiz::where('id_material', $idMaterial[0])
            ->where('id_user', Auth::user()->id)
            ->first();
            if($existingResult){

            return redirect()->route('quiz.results', $existingResult->id);

            }
    
        // Jika ingin memungkinkan pengguna mengerjakan ulang, Anda bisa menambahkan logika di sini
        // Misalnya, menghapus hasil sebelumnya atau menambahkan kolom attempt di tabel result_quizzes
    
        session([
            'quiz.questions' => $countQuestion->pluck('id')->toArray(),
            'quiz.current' => 0,
            'idMaterial' => $idMaterial,
        ]);
    
        session()->save();
    
        return redirect()->route('quiz.show', $idQuestion);
    }
    
    // Metode lainnya tetap sama
    
    public function show(string $id)
    {
        $questions = session('quiz.questions', []);
        $currentIndex = session('quiz.current', 0);
        
        if ($currentIndex >= count($questions)) {
            return redirect()->route('quiz.result');
        }
        
        $questionId = $questions[$currentIndex];
        $question = Question::find($questionId);

        session()->push('quiz.questionn', [
            'id_question' => $question->id,
            'question' => $question->question,
        ]);
        session()->save();

        if (!$question) {
            return redirect()->route('quiz.result');
        }
        
        return view('user.quiz', [
            'question' => $question,
            'currentQuestion' => $currentIndex + 1,
            'totalQuestions' => count($questions),
        ]);
    }
    
    public function storeAnswer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|exists:answers,id',
        ]);
    
        $selectedAnswer = Answer::find($request->answer);
    
        session()->push('quiz.answers', [
            'question_id' => $selectedAnswer->id_question,
            'answer_id' => $selectedAnswer->id,
            'is_correct' => $selectedAnswer->correctAnswer,
        ]);
    
        session()->save();
        session()->increment('quiz.current');
    
        return redirect()->route('quiz.show', ['id' => $id + 1]);
    }
    
    public function previousQuestion($id)
    {
        $currentIndex = session('quiz.current', 0);
    
        if ($currentIndex > 0) {
            session()->decrement('quiz.current');
    
            $answers = session('quiz.answers', []);
            if (!empty($answers)) {
                array_pop($answers);
                session(['quiz.answers' => $answers]);
            }
    
            return redirect()->route('quiz.show', ['id' => $id - 1]);
        }
    
        return redirect()->back();
    }

    public function resultQuiz($id){
        $result = resultQuiz::findOrFail($id);
        $idMaterial = $result->id_material;
        $totalQuestions = $result->totalQuestion;
        $correctAnswers = $result->correctAnswers;
        $answers = $result->resultAnswers;
        $id_answer = [];
        
        foreach($answers as $answer){
            $id_answer[] = $answer['id'];
        }
        $answerData = Answer::whereIn('id', $id_answer)->with('question')->get();
        $data['answerData'] = $answerData;
        $data['totalQuestions'] = $totalQuestions;
        $data['correctAnswers'] = $correctAnswers;
        $data['idMaterial'] = $idMaterial;
        return view('user.result', $data);
    }
    
}