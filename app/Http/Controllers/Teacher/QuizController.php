<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Material;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

        $idMaterial['idMaterial'] = $id;
        return view('teacher.addQuiz',$idMaterial);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'material_name' => 'required|string|max:255',
        //     'questions' => 'required|array|min:1',
        //     'questions.*' => 'required|string|max:500',
        //     'answers' => 'required|array',
        //     'answers.*' => 'required|array',
        //     'answers.*.*' => 'required|string|max:500',
        //     'correct_answers' => 'required|array',
        //     'correct_answers.*' => 'required|integer'
        // ]);
    
        // // Create the material first
        // $material = Material::create([
        //     'name' => $request->material_name,
        //     // Add any other material-related fields
        // ]);

        // Loop through questions and store them
        foreach ($request->questions as $questionIndex => $questionText) {
            // Create question
            $question = Question::create([
                'id_material' => $request->idMaterial,
                'question' => $questionText
            ]);
            
            
            foreach ($request->answers[$questionIndex] as $answerIndex => $answerText) {
                $isCorrect = in_array($answerIndex, $request->correct_answers[$questionIndex]);
                $answer = Answer::create([
                    'id_question' => $question->id,
                    'choices' => $answerText,
                    'correctAnswer' => $isCorrect
                ]);
            }
        }
        
        return redirect()->route('get.subMateri',$request->idMaterial)->with('success', 'Quiz created successfully');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
