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

        // Bulk aggregation — 2 queries instead of 4N
        $logStats = LearningLog::where('id_user', $userId)
            ->whereIn('id_material', $materialIds)
            ->selectRaw('id_material, SUM(duration) as total_duration, COUNT(DISTINCT id_sub_material) as opened_count')
            ->groupBy('id_material')
            ->get()
            ->keyBy('id_material');

        $subCounts = SubMaterial::whereIn('id_material', $materialIds)
            ->selectRaw('id_material, COUNT(*) as total')
            ->groupBy('id_material')
            ->get()
            ->keyBy('id_material');

        $quizResults = ResultQuiz::where('id_user', $userId)
            ->whereIn('id_material', $materialIds)
            ->get()
            ->keyBy('id_material');

        $progressData = $materials->map(function ($material) use ($logStats, $subCounts, $quizResults) {
            $totalSubs     = $subCounts->get($material->id)?->total ?? 0;
            $openedSubs    = $logStats->get($material->id)?->opened_count ?? 0;
            $totalDuration = (int) ($logStats->get($material->id)?->total_duration ?? 0);
            $quiz          = $quizResults->get($material->id);
            $percentage    = $totalSubs > 0 ? round(($openedSubs / $totalSubs) * 100) : 0;

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
        $userId = Auth::id();

        // Check enrollment BEFORE loading the material (prevents info disclosure)
        if (! MaterialUser::where('id_user', $userId)->where('id_material', $id)->exists()) {
            abort(403, 'Anda belum bergabung ke kelas ini.');
        }

        $material     = Material::findOrFail($id);
        $subMaterials = SubMaterial::where('id_material', $id)->get();
        $quiz         = ResultQuiz::where('id_user', $userId)->where('id_material', $id)->first();

        // Bulk fetch all logs for this material — 1 query instead of N
        $allLogs = LearningLog::where('id_user', $userId)
            ->where('id_material', $id)
            ->get()
            ->groupBy('id_sub_material');

        $subProgress = $subMaterials->map(function ($sub) use ($allLogs) {
            $logs          = $allLogs->get($sub->id, collect());
            $hasLogs       = $logs->isNotEmpty();
            $totalDuration = (int) $logs->sum('duration');
            $openCount     = $logs->count();
            $lastAccessed  = $hasLogs ? $logs->max('started_at') : null;
            return compact('sub', 'hasLogs', 'totalDuration', 'openCount', 'lastAccessed');
        });

        return view('user.progressDetail', compact('material', 'subProgress', 'quiz'));
    }
}
