# Learning Activity Tracking Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Tambahkan sistem tracking aktivitas belajar siswa (waktu buka sub-materi, durasi, status quiz) dengan dashboard per role — siswa, guru, dan admin.

**Architecture:** Satu tabel baru `learning_logs` mencatat setiap akses sub-materi (started_at, ended_at, duration). Saat siswa buka halaman sub-materi, controller insert log dan kirim `log_id` ke view. JavaScript `navigator.sendBeacon` dipanggil saat user meninggalkan halaman untuk mengisi `ended_at` dan `duration`.

**Tech Stack:** Laravel 11, Pest, Blade, Tailwind CSS, Alpine.js, Material Symbols Outlined icons, XAMPP/MySQL

---

### Task 1: Migration & Model `LearningLog`

**Files:**
- Create: `database/migrations/2026_05_20_120000_create_learning_logs_table.php`
- Create: `app/Models/LearningLog.php`

- [ ] **Step 1: Buat file migration**

```php
<?php
// database/migrations/2026_05_20_120000_create_learning_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_sub_material')->constrained('sub_materials')->onDelete('cascade');
            $table->foreignId('id_material')->constrained('materials')->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_logs');
    }
};
```

- [ ] **Step 2: Jalankan migration**

```
php artisan migrate
```

Expected: `INFO  Running migrations.` lalu baris `create_learning_logs_table` dengan status `DONE`.

- [ ] **Step 3: Buat model `LearningLog`**

```php
<?php
// app/Models/LearningLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningLog extends Model
{
    protected $fillable = [
        'id_user', 'id_sub_material', 'id_material',
        'started_at', 'ended_at', 'duration',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function subMaterial()
    {
        return $this->belongsTo(SubMaterial::class, 'id_sub_material');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material');
    }
}
```

- [ ] **Step 4: Commit**

```bash
git add database/migrations/2026_05_20_120000_create_learning_logs_table.php app/Models/LearningLog.php
git commit -m "feat: add LearningLog migration and model"
```

---

### Task 2: `LearningLogController` — endpoint start & end

**Files:**
- Create: `app/Http/Controllers/LearningLogController.php`
- Create: `tests/Feature/LearningLogTest.php`

- [ ] **Step 1: Tulis test yang akan gagal**

```php
<?php
// tests/Feature/LearningLogTest.php

use App\Models\LearningLog;
use App\Models\Material;
use App\Models\SubMaterial;
use App\Models\User;

test('student can start a learning log', function () {
    $teacher = User::factory()->create(['id_role' => 2, 'is_verified' => true]);
    $student = User::factory()->create(['id_role' => 1]);
    $material = Material::create([
        'material_title' => 'Test Material',
        'material_image' => null,
        'description'    => 'Desc',
        'id_teacher'     => $teacher->id,
    ]);
    $sub = SubMaterial::create([
        'id_material'   => $material->id,
        'title'         => 'Sub 1',
        'description'   => 'Desc',
        'file_material' => null,
        'file_pdf'      => null,
    ]);

    $response = actingAs($student)->postJson('/learning-log/start', [
        'id_sub_material' => $sub->id,
        'id_material'     => $material->id,
    ]);

    $response->assertOk()->assertJsonStructure(['log_id']);
    expect(LearningLog::count())->toBe(1);
    expect(LearningLog::first()->id_user)->toBe($student->id);
});

test('student can end a learning log', function () {
    $student = User::factory()->create(['id_role' => 1]);
    $teacher = User::factory()->create(['id_role' => 2]);
    $material = Material::create([
        'material_title' => 'Test',
        'material_image' => null,
        'description'    => 'D',
        'id_teacher'     => $teacher->id,
    ]);
    $sub = SubMaterial::create([
        'id_material'   => $material->id,
        'title'         => 'S',
        'description'   => 'D',
        'file_material' => null,
        'file_pdf'      => null,
    ]);

    $log = LearningLog::create([
        'id_user'         => $student->id,
        'id_sub_material' => $sub->id,
        'id_material'     => $material->id,
        'started_at'      => now()->subMinutes(5),
    ]);

    $response = actingAs($student)->postJson('/learning-log/end', [
        'log_id' => $log->id,
    ]);

    $response->assertOk()->assertJson(['ok' => true]);
    $log->refresh();
    expect($log->ended_at)->not->toBeNull();
    expect($log->duration)->toBeGreaterThan(0);
});

test('unauthenticated user cannot start a log', function () {
    $response = postJson('/learning-log/start', [
        'id_sub_material' => 1,
        'id_material'     => 1,
    ]);
    $response->assertStatus(401);
});
```

- [ ] **Step 2: Jalankan test — harus FAIL**

```
php artisan test tests/Feature/LearningLogTest.php
```

Expected: 3 tests FAIL dengan error `Route [learning-log/start] not defined` atau 404.

- [ ] **Step 3: Tambahkan routes untuk learning log ke `routes/web.php`**

Tambahkan di dalam grup `Route::middleware('auth')`:

```php
// Learning log tracking
Route::post('/learning-log/start', [App\Http\Controllers\LearningLogController::class, 'start'])->name('log.start');
Route::post('/learning-log/end', [App\Http\Controllers\LearningLogController::class, 'end'])->name('log.end');
```

- [ ] **Step 4: Buat controller**

```php
<?php
// app/Http/Controllers/LearningLogController.php

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
```

- [ ] **Step 5: Jalankan test — harus PASS**

```
php artisan test tests/Feature/LearningLogTest.php
```

Expected: 3 tests PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/LearningLogController.php tests/Feature/LearningLogTest.php routes/web.php
git commit -m "feat: add LearningLogController start/end endpoints"
```

---

### Task 3: Modifikasi `SubMateriController@show` + JS beacon di view

**Files:**
- Modify: `app/Http/Controllers/SubMateriController.php:62-68`
- Modify: `resources/views/user/detailMateri.blade.php`

- [ ] **Step 1: Update `SubMateriController@show`**

Ganti method `show` yang ada:

```php
public function show(string $id)
{
    $detailMateri = SubMaterial::findOrFail($id);

    $log = \App\Models\LearningLog::create([
        'id_user'         => auth()->id(),
        'id_sub_material' => $detailMateri->id,
        'id_material'     => $detailMateri->id_material,
        'started_at'      => now(),
    ]);

    return view('user.detailMateri', [
        'detailMateri' => $detailMateri,
        'logId'        => $log->id,
    ]);
}
```

- [ ] **Step 2: Tambahkan script beacon ke `detailMateri.blade.php`**

Tambahkan tepat sebelum `@endsection` paling akhir:

```blade
@section('script')
<script>
    const _logId    = {{ $logId }};
    const _csrfToken = '{{ csrf_token() }}';

    function sendEndBeacon() {
        const data = new FormData();
        data.append('log_id', _logId);
        data.append('_token', _csrfToken);
        navigator.sendBeacon('{{ route('log.end') }}', data);
    }

    window.addEventListener('beforeunload', sendEndBeacon);
    window.addEventListener('pagehide', sendEndBeacon);
</script>
@endsection
```

- [ ] **Step 3: Commit**

```bash
git add app/Http/Controllers/SubMateriController.php resources/views/user/detailMateri.blade.php
git commit -m "feat: insert learning log on sub-material open, send beacon on leave"
```

---

### Task 4: `ProgressController` + Student Progress Views

**Files:**
- Create: `app/Http/Controllers/ProgressController.php`
- Create: `resources/views/user/progress.blade.php`
- Create: `resources/views/user/progressDetail.blade.php`
- Modify: `routes/web.php` (tambah route progress)

- [ ] **Step 1: Tambahkan routes ke `routes/web.php`** (di dalam grup `auth`)

```php
// Student progress
Route::get('/progress', [App\Http\Controllers\ProgressController::class, 'index'])->name('progress.index');
Route::get('/progress/{id}', [App\Http\Controllers\ProgressController::class, 'show'])->name('progress.show');
```

- [ ] **Step 2: Buat controller**

```php
<?php
// app/Http/Controllers/ProgressController.php

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
        $userId     = Auth::id();
        $materialIds = MaterialUser::where('id_user', $userId)->pluck('id_material');
        $materials  = Material::whereIn('id', $materialIds)->get();

        $progressData = $materials->map(function ($material) use ($userId) {
            $totalSubs  = SubMaterial::where('id_material', $material->id)->count();
            $openedSubs = LearningLog::where('id_user', $userId)
                ->where('id_material', $material->id)
                ->distinct('id_sub_material')
                ->count('id_sub_material');
            $totalDuration = (int) LearningLog::where('id_user', $userId)
                ->where('id_material', $material->id)
                ->sum('duration');
            $quiz = ResultQuiz::where('id_user', $userId)
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
```

- [ ] **Step 3: Buat view `resources/views/user/progress.blade.php`**

```blade
@extends('user.layouts.headers')

@section('pageTitle', 'Progress Belajar Saya')

@section('mainContent')
@php
function fmtDur($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' dtk';
    if ($s < 3600) return round($s / 60) . ' mnt';
    return number_format($s / 3600, 1) . ' jam';
}
@endphp
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                <span class="material-symbols-outlined">school</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Kelas Diikuti</p>
                <p class="text-3xl font-bold text-slate-800">{{ $totalClasses }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined">schedule</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Waktu Belajar</p>
                <p class="text-3xl font-bold text-slate-800">{{ fmtDur($totalDuration) }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">star</span>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Rata-rata Skor Quiz</p>
                <p class="text-3xl font-bold text-slate-800">{{ $avgScore }}</p>
            </div>
        </div>
    </div>

    {{-- Per Class Progress --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800">Progress per Kelas</h2>
        </div>
        @if($progressData->isEmpty())
        <div class="p-10 text-center text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-2">inbox</span>
            <p>Anda belum bergabung ke kelas apapun.</p>
        </div>
        @else
        <ul class="divide-y divide-slate-100">
            @foreach($progressData as $item)
            <li class="p-5 flex flex-col sm:flex-row sm:items-center gap-4 hover:bg-slate-50 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <a href="{{ route('progress.show', $item['material']->id) }}" class="font-semibold text-slate-800 hover:text-indigo-600 transition-colors">
                            {{ $item['material']->material_title }}
                        </a>
                        <span class="text-sm font-bold text-indigo-600">{{ $item['percentage'] }}%</span>
                    </div>
                    {{-- Progress Bar --}}
                    <div class="w-full bg-slate-100 rounded-full h-2 mb-3">
                        <div class="bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $item['percentage'] }}%"></div>
                    </div>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">menu_book</span>
                            {{ $item['openedSubs'] }}/{{ $item['totalSubs'] }} sub-materi
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            {{ fmtDur($item['totalDuration']) }}
                        </span>
                        @if($item['quiz'])
                        <span class="flex items-center gap-1 text-emerald-600 font-medium">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                            Quiz: {{ $item['quiz']->score }}
                        </span>
                        @else
                        <span class="flex items-center gap-1 text-slate-400">
                            <span class="material-symbols-outlined text-[14px]">radio_button_unchecked</span>
                            Quiz belum dikerjakan
                        </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('progress.show', $item['material']->id) }}" class="shrink-0 p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat detail">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>
@endsection
```

- [ ] **Step 4: Buat view `resources/views/user/progressDetail.blade.php`**

```blade
@extends('user.layouts.headers')

@section('pageTitle', 'Detail Progress — ' . $material->material_title)

@section('mainContent')
@php
function fmtDurD($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' detik';
    if ($s < 3600) return round($s / 60) . ' menit';
    return number_format($s / 3600, 1) . ' jam';
}
@endphp
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('progress.index') }}" class="text-sm text-slate-500 hover:text-indigo-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-1">{{ $material->material_title }}</h2>
        @if($quiz)
        <span class="inline-flex items-center gap-1 text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
            <span class="material-symbols-outlined text-[16px]">check_circle</span> Quiz selesai — Skor: {{ $quiz->score }}
        </span>
        @else
        <span class="inline-flex items-center gap-1 text-sm text-slate-400 bg-slate-50 px-3 py-1 rounded-full">
            <span class="material-symbols-outlined text-[16px]">radio_button_unchecked</span> Quiz belum dikerjakan
        </span>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Daftar Sub-Materi</h3>
        </div>
        <ul class="divide-y divide-slate-100">
            @foreach($subProgress as $item)
            <li class="p-5 flex items-start gap-4">
                <div class="shrink-0 mt-0.5">
                    @if($item['logs']->isNotEmpty())
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    @else
                    <span class="material-symbols-outlined text-slate-300">radio_button_unchecked</span>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-slate-800">{{ $item['sub']->title }}</p>
                    @if($item['logs']->isNotEmpty())
                    <div class="flex flex-wrap gap-x-4 text-xs text-slate-500 mt-1">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">schedule</span>
                            Total: {{ fmtDurD($item['totalDuration']) }}
                        </span>
                        @if($item['lastAccessed'])
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">history</span>
                            Terakhir: {{ \Carbon\Carbon::parse($item['lastAccessed'])->diffForHumans() }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">replay</span>
                            Dibuka {{ $item['logs']->count() }}x
                        </span>
                    </div>
                    @else
                    <p class="text-xs text-slate-400 mt-1">Belum dibuka</p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection
```

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/ProgressController.php resources/views/user/progress.blade.php resources/views/user/progressDetail.blade.php routes/web.php
git commit -m "feat: add student progress dashboard (index + detail)"
```

---

### Task 5: Tambahkan link Progress ke sidebar siswa

**Files:**
- Modify: `resources/views/user/layouts/headers.blade.php:52-74`

- [ ] **Step 1: Tambahkan link "Progress Saya" di nav sidebar**

Tambahkan setelah link "Setting" (sekitar baris 57), di dalam blok `@if(auth()->check())`:

```blade
<a href="{{ route('progress.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ Route::currentRouteName() == 'progress.index' || Route::currentRouteName() == 'progress.show' ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}" :class="sidebarMini ? 'lg:justify-center lg:px-0' : ''" title="Progress Belajar">
    <span class="material-symbols-outlined {{ Route::currentRouteName() == 'progress.index' || Route::currentRouteName() == 'progress.show' ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-500 transition-colors' }}" :class="sidebarMini ? 'mr-0' : 'mr-3'">insights</span>
    <span :class="sidebarMini ? 'lg:hidden' : ''" class="whitespace-nowrap">Progress Saya</span>
</a>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/user/layouts/headers.blade.php
git commit -m "feat: add Progress link to user sidebar"
```

---

### Task 6: Teacher `AnalyticsController` + Views

**Files:**
- Create: `app/Http/Controllers/Teacher/AnalyticsController.php`
- Create: `resources/views/teacher/analytics.blade.php`
- Create: `resources/views/teacher/analyticsStudent.blade.php`
- Modify: `routes/web.php` (tambah routes teacher analytics)

- [ ] **Step 1: Tambahkan routes ke grup teacher di `routes/web.php`**

```php
// Teacher analytics
Route::get('/teacher/analytics/{id}', [App\Http\Controllers\Teacher\AnalyticsController::class, 'show'])->name('teacher.analytics');
Route::get('/teacher/analytics/{id_material}/student/{id_student}', [App\Http\Controllers\Teacher\AnalyticsController::class, 'studentDetail'])->name('teacher.analytics.student');
```

- [ ] **Step 2: Buat controller**

```php
<?php
// app/Http/Controllers/Teacher/AnalyticsController.php

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
        $material = Material::where('id', $id)->where('id_teacher', Auth::id())->firstOrFail();
        $totalSubs = SubMaterial::where('id_material', $id)->count();

        $studentIds = MaterialUser::where('id_material', $id)->pluck('id_user');
        $students   = User::whereIn('id', $studentIds)->get();
        $quizResults = ResultQuiz::where('id_material', $id)->whereIn('id_user', $studentIds)->get();

        $avgScore      = round($quizResults->avg('score') ?? 0, 1);
        $quizDoneCount = $quizResults->unique('id_user')->count();

        $studentsProgress = $students->map(function ($student) use ($id, $totalSubs, $quizResults) {
            $opened = LearningLog::where('id_user', $student->id)
                ->where('id_material', $id)
                ->distinct('id_sub_material')
                ->count('id_sub_material');
            $totalDuration = (int) LearningLog::where('id_user', $student->id)
                ->where('id_material', $id)
                ->sum('duration');
            $lastAccess = LearningLog::where('id_user', $student->id)
                ->where('id_material', $id)
                ->max('started_at');
            $quiz       = $quizResults->where('id_user', $student->id)->first();
            $percentage = $totalSubs > 0 ? round(($opened / $totalSubs) * 100) : 0;

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

        $subProgress = $subMaterials->map(function ($sub) use ($idStudent) {
            $logs          = LearningLog::where('id_user', $idStudent)->where('id_sub_material', $sub->id)->get();
            $totalDuration = (int) $logs->sum('duration');
            $lastAccessed  = $logs->max('started_at');
            $accessCount   = $logs->count();
            return compact('sub', 'logs', 'totalDuration', 'lastAccessed', 'accessCount');
        });

        return view('teacher.analyticsStudent', compact('material', 'student', 'subProgress', 'quiz'));
    }
}
```

- [ ] **Step 3: Buat view `resources/views/teacher/analytics.blade.php`**

```blade
@extends('teacher.layouts.headers')

@section('pageTitle', 'Analitik — ' . $material->material_title)

@section('teacherContent')
@php
function fmtT($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' dtk';
    if ($s < 3600) return round($s / 60) . ' mnt';
    return number_format($s / 3600, 1) . ' jam';
}
@endphp
<div class="space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.home') }}" class="text-sm text-slate-500 hover:text-emerald-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali
        </a>
        <h2 class="text-xl font-bold text-slate-800">{{ $material->material_title }}</h2>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Siswa</p>
            <p class="text-3xl font-bold text-slate-800">{{ $totalStudents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Progress</p>
            <p class="text-3xl font-bold text-emerald-600">{{ $avgProgress }}%</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Skor Quiz</p>
            <p class="text-3xl font-bold text-amber-500">{{ $avgScore }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Quiz Selesai</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $quizDoneCount }}<span class="text-lg text-slate-400">/{{ $totalStudents }}</span></p>
        </div>
    </div>

    {{-- Student Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Progress per Siswa</h3>
        </div>
        @if($studentsProgress->isEmpty())
        <div class="p-10 text-center text-slate-400">Belum ada siswa yang bergabung.</div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">Siswa</th>
                        <th class="px-5 py-3 text-left font-semibold">Progress</th>
                        <th class="px-5 py-3 text-left font-semibold">Waktu Belajar</th>
                        <th class="px-5 py-3 text-left font-semibold">Quiz</th>
                        <th class="px-5 py-3 text-left font-semibold">Akses Terakhir</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($studentsProgress as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $item['student']->name }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-24 bg-slate-100 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width:{{ $item['percentage'] }}%"></div>
                                </div>
                                <span class="text-xs font-semibold text-slate-600">{{ $item['opened'] }}/{{ $item['totalSubs'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ fmtT($item['totalDuration']) }}</td>
                        <td class="px-5 py-4">
                            @if($item['quiz'])
                            <span class="text-emerald-600 font-semibold">{{ $item['quiz']->score }}</span>
                            @else
                            <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-slate-500 text-xs">
                            {{ $item['lastAccess'] ? \Carbon\Carbon::parse($item['lastAccess'])->diffForHumans() : '—' }}
                        </td>
                        <td class="px-5 py-4">
                            <a href="{{ route('teacher.analytics.student', [$material->id, $item['student']->id]) }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
@endsection
```

- [ ] **Step 4: Buat view `resources/views/teacher/analyticsStudent.blade.php`**

```blade
@extends('teacher.layouts.headers')

@section('pageTitle', 'Detail — ' . $student->name)

@section('teacherContent')
@php
function fmtTS($s) {
    $s = (int)$s;
    if ($s < 60) return $s . ' detik';
    if ($s < 3600) return round($s / 60) . ' menit';
    return number_format($s / 3600, 1) . ' jam';
}
@endphp
<div class="max-w-3xl space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('teacher.analytics', $material->id) }}" class="text-sm text-slate-500 hover:text-emerald-600 flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Analitik
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6">
        <p class="text-sm text-slate-500 mb-1">{{ $material->material_title }}</p>
        <h2 class="text-xl font-bold text-slate-800">{{ $student->name }}</h2>
        @if($quiz)
        <span class="inline-flex items-center gap-1 mt-2 text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full font-medium">
            <span class="material-symbols-outlined text-[16px]">check_circle</span> Quiz — Skor: {{ $quiz->score }}
        </span>
        @else
        <span class="inline-flex items-center gap-1 mt-2 text-sm text-slate-400 bg-slate-50 px-3 py-1 rounded-full">
            Quiz belum dikerjakan
        </span>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-700">Detail Sub-Materi</h3>
        </div>
        <ul class="divide-y divide-slate-100">
            @foreach($subProgress as $item)
            <li class="p-5 flex items-start gap-4">
                <div class="shrink-0 mt-0.5">
                    @if($item['logs']->isNotEmpty())
                    <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                    @else
                    <span class="material-symbols-outlined text-slate-300">radio_button_unchecked</span>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $item['sub']->title }}</p>
                    @if($item['logs']->isNotEmpty())
                    <div class="flex flex-wrap gap-x-4 text-xs text-slate-500 mt-1">
                        <span>Durasi total: {{ fmtTS($item['totalDuration']) }}</span>
                        <span>Dibuka {{ $item['accessCount'] }}x</span>
                        @if($item['lastAccessed'])
                        <span>Terakhir: {{ \Carbon\Carbon::parse($item['lastAccessed'])->diffForHumans() }}</span>
                        @endif
                    </div>
                    @else
                    <p class="text-xs text-slate-400 mt-1">Belum pernah dibuka</p>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection
```

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/Teacher/AnalyticsController.php resources/views/teacher/analytics.blade.php resources/views/teacher/analyticsStudent.blade.php routes/web.php
git commit -m "feat: add teacher analytics controller and views"
```

---

### Task 7: Tambahkan tombol Analitik ke teacher home + sidebar

**Files:**
- Modify: `resources/views/teacher/home.blade.php:92-99`
- Modify: `resources/views/teacher/layouts/headers.blade.php:44-57`

- [ ] **Step 1: Tambahkan tombol "Analitik" di action per kelas di `teacher/home.blade.php`**

Pada bagian `<!-- Actions -->` (baris 92-99), tambahkan tombol analitik di samping tombol edit:

```blade
<div class="flex items-center gap-2 sm:opacity-0 group-hover:opacity-100 transition-opacity">
    <a href="{{ route('teacher.analytics', $material->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors tooltip" title="Analitik Kelas">
        <span class="material-symbols-outlined">insights</span>
    </a>
    <a href="{{route('get.subMateri', $material->id)}}" class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors tooltip" title="Kelola Kelas">
        <span class="material-symbols-outlined">edit</span>
    </a>
    <a href="#" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors tooltip" title="Hapus Kelas">
        <span class="material-symbols-outlined">delete</span>
    </a>
</div>
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/teacher/home.blade.php
git commit -m "feat: add analytics button to teacher class list"
```

---

### Task 8: Admin Analytics Section

**Files:**
- Modify: `app/Http/Controllers/admin/AdminController.php:16-27`
- Modify: `resources/views/admin/admin.blade.php`

- [ ] **Step 1: Update `AdminController@index`**

Ganti method `index` yang ada:

```php
public function index()
{
    $teacher  = User::where('id_role', 2)->where('is_verified', true)->count();
    $material = Material::count();
    $student  = User::where('id_role', 1)->count();

    $days  = (int) request('period', 30);
    $since = now()->subDays($days);

    $activeStudents   = \App\Models\LearningLog::where('started_at', '>=', $since)->distinct('id_user')->count('id_user');
    $totalStudyTime   = (int) \App\Models\LearningLog::where('started_at', '>=', $since)->sum('duration');
    $totalQuizzes     = \App\Models\ResultQuiz::where('created_at', '>=', $since)->count();
    $avgPlatformScore = round(\App\Models\ResultQuiz::where('created_at', '>=', $since)->avg('score') ?? 0, 1);

    $topMaterials = Material::with('userTeacher')->get()->map(function ($mat) use ($since) {
        $mat->access_count = \App\Models\LearningLog::where('id_material', $mat->id)
            ->where('started_at', '>=', $since)->count();
        $mat->student_count = \App\Models\MaterialUser::where('id_material', $mat->id)->count();
        $mat->avg_score     = round(\App\Models\ResultQuiz::where('id_material', $mat->id)
            ->where('created_at', '>=', $since)->avg('score') ?? 0, 1);
        return $mat;
    })->sortByDesc('access_count')->take(5);

    $topStudents = User::where('id_role', 1)->get()->map(function ($s) use ($since) {
        $s->total_duration = (int) \App\Models\LearningLog::where('id_user', $s->id)
            ->where('started_at', '>=', $since)->sum('duration');
        $s->class_count    = \App\Models\MaterialUser::where('id_user', $s->id)->count();
        $s->avg_score      = round(\App\Models\ResultQuiz::where('id_user', $s->id)
            ->where('created_at', '>=', $since)->avg('score') ?? 0, 1);
        return $s;
    })->sortByDesc('total_duration')->take(5);

    return view('admin.admin', compact(
        'teacher', 'material', 'student',
        'days', 'activeStudents', 'totalStudyTime', 'totalQuizzes', 'avgPlatformScore',
        'topMaterials', 'topStudents'
    ));
}
```

- [ ] **Step 2: Update `resources/views/admin/admin.blade.php`**

Tambahkan section analytics setelah Stats Grid yang sudah ada (setelah tag penutup `</div>` pada Stats Grid):

```blade
    {{-- Period Filter --}}
    <div class="mt-8 flex items-center gap-3">
        <span class="text-sm font-medium text-slate-600">Periode:</span>
        @foreach([7 => '7 Hari', 30 => '30 Hari', 90 => '3 Bulan', 0 => 'Semua'] as $d => $label)
        <a href="{{ route('admin', ['period' => $d]) }}"
           class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $days == $d ? 'bg-rose-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Activity Cards --}}
    <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        function fmtA($s) {
            $s = (int)$s;
            if ($s < 60) return $s . ' dtk';
            if ($s < 3600) return round($s / 60) . ' mnt';
            return number_format($s / 3600, 1) . ' jam';
        }
        @endphp
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Siswa Aktif</p>
            <p class="text-3xl font-bold text-slate-800">{{ $activeStudents }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Total Waktu Belajar</p>
            <p class="text-3xl font-bold text-indigo-600">{{ fmtA($totalStudyTime) }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Quiz Dikerjakan</p>
            <p class="text-3xl font-bold text-emerald-600">{{ $totalQuizzes }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)]">
            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Rata Skor Quiz</p>
            <p class="text-3xl font-bold text-amber-500">{{ $avgPlatformScore }}</p>
        </div>
    </div>

    {{-- Top Materials & Top Students --}}
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Materials --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-700">Materi Paling Aktif</h3>
            </div>
            @if($topMaterials->isEmpty())
            <div class="p-6 text-center text-slate-400 text-sm">Belum ada data.</div>
            @else
            <ul class="divide-y divide-slate-100">
                @foreach($topMaterials as $mat)
                <li class="px-5 py-3 flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 truncate">{{ $mat->material_title }}</p>
                        <p class="text-xs text-slate-500">{{ $mat->userTeacher?->name ?? '—' }} · {{ $mat->student_count }} siswa</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-indigo-600">{{ $mat->access_count }} akses</p>
                        <p class="text-xs text-slate-400">skor rata {{ $mat->avg_score }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>

        {{-- Top Students --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] overflow-hidden">
            <div class="p-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-700">Siswa Paling Aktif</h3>
            </div>
            @if($topStudents->isEmpty())
            <div class="p-6 text-center text-slate-400 text-sm">Belum ada data.</div>
            @else
            <ul class="divide-y divide-slate-100">
                @foreach($topStudents as $s)
                <li class="px-5 py-3 flex items-center justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-slate-800 truncate">{{ $s->name }}</p>
                        <p class="text-xs text-slate-500">{{ $s->class_count }} kelas · rata skor {{ $s->avg_score }}</p>
                    </div>
                    <p class="text-sm font-semibold text-emerald-600 shrink-0">{{ fmtA($s->total_duration) }}</p>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
```

Catatan: tambahkan kode di atas tepat sebelum `@endsection` di `admin.blade.php`.

- [ ] **Step 3: Update route admin agar bisa terima query param `period`**

Route admin sudah ada (`/admin`), tidak perlu diubah karena `request('period', 30)` membaca query string otomatis.

- [ ] **Step 4: Commit**

```bash
git add app/Http/Controllers/admin/AdminController.php resources/views/admin/admin.blade.php
git commit -m "feat: add analytics section to admin dashboard"
```

---

### Self-Review Checklist

Spec coverage:
- ✅ Tabel `learning_logs` (Task 1)
- ✅ Insert log saat buka sub-materi + beacon saat keluar (Task 2, 3)
- ✅ Dashboard siswa: progress per kelas, waktu, quiz, detail (Task 4, 5)
- ✅ Dashboard guru: ringkasan kelas, tabel siswa, detail siswa, filter (Task 6, 7)
- ✅ Dashboard admin: kartu statistik, materi aktif, siswa aktif, filter periode (Task 8)
- ✅ Filter periode admin berlaku untuk semua section (Task 8)
- ✅ `COALESCE` via PHP `(int)` cast + `?? 0` fallback
- ✅ Siswa dengan 0 progress tetap muncul di tabel guru (query dari `MaterialUser`)
