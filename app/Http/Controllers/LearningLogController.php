<?php

namespace App\Http\Controllers;

use App\Models\LearningLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningLogController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'id_sub_material' => 'required|exists:sub_materials,id',
            'id_material'     => 'required|exists:materials,id',
        ]);

        $log = LearningLog::create([
            'id_user'         => Auth::id(),
            'id_sub_material' => $request->id_sub_material,
            'id_material'     => $request->id_material,
            'started_at'      => now(),
        ]);

        return response()->json(['log_id' => $log->id]);
    }

    public function end(Request $request)
    {
        $request->validate([
            'log_id' => 'required|integer',
        ]);

        $log = LearningLog::where('id', $request->log_id)
            ->where('id_user', Auth::id())
            ->whereNull('ended_at')
            ->first();

        if (! $log) {
            return response()->json(['ok' => false], 404);
        }

        $log->ended_at = now();
        $log->duration = (int) $log->started_at->diffInSeconds($log->ended_at);
        $log->save();

        return response()->json(['ok' => true]);
    }
}
