<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialUser;
use App\Models\Question;
use App\Models\SubMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $teacherId = Auth::user();
        $materials = Material::where('id_teacher', $teacherId->id)->get();

        $data['materials'] = $materials;
        return view('teacher.home', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('teacher.addMateri');
    }

    /**
     * Show the form for creating a new sub-material.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function createSubMateri($id)
    {
        $data['idMaterial'] = $id;
        return view('teacher.addSubMateri', $data);
    }

    /**
     * Display sub-materials for a specific material.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function indexSubMateri($id)
    {
        $idMateri = $id;
        $material = Material::findOrFail($idMateri);
        $subMateri = SubMaterial::where('id_material', $idMateri)->get();
        $id_question = Question::where('id_material', $idMateri)->pluck('id')->first();

        $data = [
            'material' => $material,
            'subMateri' => $subMateri,
            'idMateri' => $idMateri
        ];

        if ($id_question) {
            $data['question'] = $id_question;
        }

        return view('teacher.subMateri', $data);
    }

    /**
     * Store a newly created material in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $teacherId = Auth::user();
        $fileName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $fileName);
        }

        Material::create([
            'material_title' => $request->material_title,
            'material_image' => $fileName,
            'description' => $request->description,
            'id_teacher' => $teacherId->id
        ]);

        return redirect()->route('teacher.home');
    }

    /**
     * Store a video file for sub-material.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeVideo(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:mp4,avi,mkv,webm|max:512000', // Maximum 500MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('assets/video'), $fileName);

            $subMaterial = new SubMaterial();
            $subMaterial->file_material = $fileName;
            $subMaterial->save();

            session()->push('id_subMaterial', $subMaterial->id);

            return response()->json(['success' => true, 'file' => $fileName]);
        }

        return response()->json(['success' => false], 400);
    }

    /**
     * Store a new sub-material or update an existing one.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeSubMateri(Request $request)
    {
        $idMaterial = $request->idMaterial;

        if (session()->has('id_subMaterial')) {
            $id_subMateri = session()->get('id_subMaterial');
            session()->forget('id_subMaterial');

            SubMaterial::where('id', $id_subMateri)->update([
                'id_material' => $idMaterial,
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            SubMaterial::create([
                'id_material' => $idMaterial,
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('get.subMateri', $idMaterial);
    }

    /**
     * Display users who have joined a specific material.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function showJoin(string $id)
    {
        $material_users = MaterialUser::where('id_material', $id)->get();
        $idUser = $material_users->pluck('id_user')->toArray();
        $user = User::whereIn('id', $idUser)->get();

        $data = [
            'userJoin' => $user,
            'idMaterial' => $id
        ];

        return view('teacher.userJoin', $data);
    }

    /**
     * Edit method (currently not implemented).
     *
     * @param string $id
     */
    public function edit(string $id)
    {
        // TODO: Implement edit functionality
    }

    /**
     * Update method (currently not implemented).
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement update functionality
    }

    /**
     * Remove a specific sub-material.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroySubMateri(string $id)
    {
        $subMateri = SubMaterial::findOrFail($id);
        $subMateri->delete();
        
        return redirect()->route('get.subMateri', $subMateri->id_material);
    }
}