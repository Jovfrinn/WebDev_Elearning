<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher = count(User::where('id_role',2)->where('is_verified', true)->get());
        $material = count(Material::all());
        $student = count(User::where('id_role',1)->get());

        $data['teacher'] = $teacher;
        $data['material'] = $material;
        $data['student'] = $student;

        return view('admin.admin', $data);
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
