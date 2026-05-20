<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher  = User::where('id_role', 2)->where('is_verified', true)->count();
        $material = Material::count();
        $student  = User::where('id_role', 1)->count();

        $days  = max(0, (int) request('period', 30));
        $since = $days > 0 ? now()->subDays($days) : null;

        $logsQuery = \App\Models\LearningLog::query();
        $quizQuery = \App\Models\ResultQuiz::query();

        if ($since) {
            $logsQuery->where('started_at', '>=', $since);
            $quizQuery->where('created_at', '>=', $since);
        }

        $activeStudents   = (clone $logsQuery)->distinct('id_user')->count('id_user');
        $totalStudyTime   = (int) (clone $logsQuery)->sum('duration');
        $totalQuizzes     = (clone $quizQuery)->count();
        $avgPlatformScore = round((clone $quizQuery)->avg('score') ?? 0, 1);

        // Bulk aggregations for topMaterials
        $materialAccessCounts = (clone $logsQuery)
            ->selectRaw('id_material, COUNT(*) as access_count')
            ->groupBy('id_material')
            ->get()
            ->keyBy('id_material');

        $materialQuizScores = (clone $quizQuery)
            ->selectRaw('id_material, AVG(score) as avg_score')
            ->groupBy('id_material')
            ->get()
            ->keyBy('id_material');

        $topMaterials = Material::with('userTeacher')
            ->withCount('users as student_count')
            ->get()
            ->map(function ($mat) use ($materialAccessCounts, $materialQuizScores) {
                $mat->access_count = $materialAccessCounts->get($mat->id)?->access_count ?? 0;
                $mat->avg_score    = round($materialQuizScores->get($mat->id)?->avg_score ?? 0, 1);
                return $mat;
            })
            ->sortByDesc('access_count')
            ->take(5);

        // Bulk aggregations for topStudents
        $studentDurations = (clone $logsQuery)
            ->selectRaw('id_user, SUM(duration) as total_duration')
            ->groupBy('id_user')
            ->get()
            ->keyBy('id_user');

        $studentQuizScores = (clone $quizQuery)
            ->selectRaw('id_user, AVG(score) as avg_score')
            ->groupBy('id_user')
            ->get()
            ->keyBy('id_user');

        $studentClassCounts = \App\Models\MaterialUser::selectRaw('id_user, COUNT(*) as class_count')
            ->groupBy('id_user')
            ->get()
            ->keyBy('id_user');

        $topStudents = User::where('id_role', 1)->get()->map(function ($s) use ($studentDurations, $studentQuizScores, $studentClassCounts) {
            $s->total_duration = (int) ($studentDurations->get($s->id)?->total_duration ?? 0);
            $s->class_count    = $studentClassCounts->get($s->id)?->class_count ?? 0;
            $s->avg_score      = round($studentQuizScores->get($s->id)?->avg_score ?? 0, 1);
            return $s;
        })->sortByDesc('total_duration')->take(5);

        return view('admin.admin', compact(
            'teacher', 'material', 'student',
            'days', 'activeStudents', 'totalStudyTime', 'totalQuizzes', 'avgPlatformScore',
            'topMaterials', 'topStudents'
        ));
    }

    public function getTeacher(){
        $pendingUsers = User::where('id_role', 2)->where('is_verified', false)->get();


        return view('admin.verifyTeacher', compact('pendingUsers'));
    
    }

    public function verifikasi($id)
    {
        $user = User::findOrFail($id);
        $user->is_verified = true;
        $user->save();

        return redirect()->route('get.teacher')->with('success', 'Guru berhasil diverifikasi.');
    }

    public function deleteTeacher($id)
    {
        $teacher = User::findOrFail($id);
        $teacher->delete();

        return redirect()->route('get.teacher')->with('success', 'Guru berhasil dihapus.');
    }

    public function student()
    {
        $student = User::where('id_role',1)->get();
        $count = count($student);
        $data['students'] = $student;
        $data['count'] = $count;
        return view('admin.student',$data);
    }

    public function teacher()
    {
        $teacher = User::where('id_role',2)->where('is_verified', true)->get();
        $count = count($teacher);


        $data['teachers'] = $teacher;
        $data['count'] = $count;
        return view('admin.teacher', $data);
    }

    public function materi()
    {
        $materials = Material::with('userTeacher')->get();
        $data['materials'] = $materials;
        return view('admin.material',$data);
    }
    /**
     * Show form to create a new teacher account (by admin).
     */
    public function createTeacher()
    {
        return view('admin.createTeacher');
    }

    /**
     * Store a newly created teacher account.
     */
    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'nip'      => 'required|string|max:50|unique:users,nip',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh akun lain.',
            'nip.required'       => 'NIP wajib diisi.',
            'nip.unique'         => 'NIP sudah digunakan oleh akun lain.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'nip'         => $request->nip,
            'password'    => Hash::make($request->password),
            'id_role'     => 2,       // role guru
            'is_verified' => false,   // belum diverifikasi, harus login dulu lalu admin verify
        ]);

        return redirect()->route('get.teachers')
            ->with('success', 'Akun guru berhasil dibuat! Guru dapat login dan menunggu verifikasi.');
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
        //
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
