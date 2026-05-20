<?php

namespace App\Http\Controllers;

use App\Models\LearningLog;
use App\Models\Material;
use App\Models\MaterialUser;
use App\Models\ResultQuiz;
use App\Models\SubMaterial;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $userId      = Auth::id();
        $materialIds = MaterialUser::where('id_user', $userId)->pluck('id_material');
        $materials   = Material::whereIn('id', $materialIds)->get();

        $progressData = $materials->map(function ($material) use ($userId) {
            $totalSubs  = SubMaterial::where('id_material', $material->id)->count();
            $openedSubs = LearningLog::where('id_user', $userId)
                ->where('id_material', $material->id)
                ->distinct('id_sub_material')
                ->count('id_sub_material');
            $totalDuration = (int) LearningLog::where('id_user', $userId)
                ->where('id_material', $material->id)
                ->sum('duration');
            $quiz       = ResultQuiz::where('id_user', $userId)
                ->where('id_material', $material->id)
                ->first();
            $percentage = $totalSubs > 0 ? round(($openedSubs / $totalSubs) * 100) : 0;

            return compact('material', 'totalSubs', 'openedSubs', 'percentage', 'totalDuration', 'quiz');
        });

        $totalDuration = (int) LearningLog::where('id_user', $userId)->sum('duration');
        $avgScore      = round(ResultQuiz::where('id_user', $userId)->avg('score') ?? 0, 1);

        return view('user.progress', [
            'progressData'  => $progressData,
            'totalClasses'  => $materials->count(),
            'totalDuration' => $totalDuration,
            'avgScore'      => $avgScore,
        ]);
    }

    public function show($id)
    {
        $userId   = Auth::id();
        $material = Material::findOrFail($id);

        if (! MaterialUser::where('id_user', $userId)->where('id_material', $id)->exists()) {
            abort(403, 'Anda belum bergabung ke kelas ini.');
        }

        $subMaterials = SubMaterial::where('id_material', $id)->get();
        $quiz         = ResultQuiz::where('id_user', $userId)->where('id_material', $id)->first();

        $subProgress = $subMaterials->map(function ($sub) use ($userId) {
            $logs          = LearningLog::where('id_user', $userId)->where('id_sub_material', $sub->id)->get();
            $totalDuration = (int) $logs->sum('duration');
            $lastAccessed  = $logs->max('started_at');
            return compact('sub', 'logs', 'totalDuration', 'lastAccessed');
        });

        return view('user.progressDetail', compact('material', 'subProgress', 'quiz'));
    }
}
