<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LearningLog;
use App\Models\Material;
use App\Models\MaterialUser;
use App\Models\ResultQuiz;
use App\Models\SubMaterial;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function show($id)
    {
        $material  = Material::where('id', $id)->where('id_teacher', Auth::id())->firstOrFail();
        $totalSubs = SubMaterial::where('id_material', $id)->count();

        $studentIds  = MaterialUser::where('id_material', $id)->pluck('id_user');
        $students    = User::whereIn('id', $studentIds)->get();
        $quizResults = ResultQuiz::where('id_material', $id)->whereIn('id_user', $studentIds)->get();

        // Bulk log stats per student
        $logStats = LearningLog::where('id_material', $id)
            ->whereIn('id_user', $studentIds)
            ->selectRaw('id_user, SUM(duration) as total_duration, COUNT(DISTINCT id_sub_material) as opened_count, MAX(started_at) as last_access')
            ->groupBy('id_user')
            ->get()
            ->keyBy('id_user');

        $avgScore      = round($quizResults->avg('score') ?? 0, 1);
        $quizDoneCount = $quizResults->unique('id_user')->count();

        $studentsProgress = $students->map(function ($student) use ($id, $totalSubs, $quizResults, $logStats) {
            $stats         = $logStats->get($student->id);
            $opened        = $stats?->opened_count ?? 0;
            $totalDuration = (int) ($stats?->total_duration ?? 0);
            $lastAccess    = $stats?->last_access;
            $quiz          = $quizResults->where('id_user', $student->id)->first();
            $percentage    = $totalSubs > 0 ? round(($opened / $totalSubs) * 100) : 0;

            return compact('student', 'opened', 'totalSubs', 'percentage', 'totalDuration', 'lastAccess', 'quiz');
        });

        $avgProgress = round($studentsProgress->avg('percentage') ?? 0);

        return view('teacher.analytics', [
            'material'         => $material,
            'studentsProgress' => $studentsProgress,
            'totalStudents'    => $students->count(),
            'avgProgress'      => $avgProgress,
            'avgScore'         => $avgScore,
            'quizDoneCount'    => $quizDoneCount,
            'quizNotDoneCount' => $students->count() - $quizDoneCount,
        ]);
    }

    public function studentDetail($idMaterial, $idStudent)
    {
        $material = Material::where('id', $idMaterial)->where('id_teacher', Auth::id())->firstOrFail();
        $student  = User::findOrFail($idStudent);

        $subMaterials = SubMaterial::where('id_material', $idMaterial)->get();
        $quiz         = ResultQuiz::where('id_user', $idStudent)->where('id_material', $idMaterial)->first();

        $allLogs = LearningLog::where('id_user', $idStudent)
            ->where('id_material', $idMaterial)
            ->get()
            ->groupBy('id_sub_material');

        $subProgress = $subMaterials->map(function ($sub) use ($allLogs) {
            $logs          = $allLogs->get($sub->id, collect());
            $hasLogs       = $logs->isNotEmpty();
            $totalDuration = (int) $logs->sum('duration');
            $lastAccessed  = $hasLogs ? $logs->max('started_at') : null;
            $accessCount   = $logs->count();
            return compact('sub', 'hasLogs', 'totalDuration', 'lastAccessed', 'accessCount');
        });

        return view('teacher.analyticsStudent', compact('material', 'student', 'subProgress', 'quiz'));
    }
}
