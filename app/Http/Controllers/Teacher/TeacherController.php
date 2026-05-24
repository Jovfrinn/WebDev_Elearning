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
        // Validate by extension instead of MIME type to avoid false rejections
        $allowedExtensions = ['mp4', 'avi', 'mkv', 'webm', 'mov'];

        if (!$request->hasFile('file')) {
            return response()->json(['success' => false, 'message' => 'Tidak ada file yang diunggah.'], 400);
        }

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            return response()->json(['success' => false, 'message' => 'Format file tidak didukung. Gunakan MP4, AVI, MKV, WEBM, atau MOV.'], 422);
        }

        // Max 1GB (1048576 KB)
        if ($file->getSize() > 1048576 * 1024) {
            return response()->json(['success' => false, 'message' => 'Ukuran file melebihi 1GB.'], 422);
        }

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/video'), $fileName);

        // Simpan nama file ke session (jangan buat row DB dulu karena field title tidak boleh null)
        session(['uploaded_video' => $fileName]);

        return response()->json(['success' => true, 'file' => $fileName]);
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

        // Handle PDF upload
        $pdfFileName = null;
        if ($request->hasFile('file_pdf')) {
            $pdf = $request->file('file_pdf');
            $pdfFileName = 'pdf_' . time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('assets/pdf'), $pdfFileName);
        }

        // Ambil nama file video dari session jika ada
        $videoFileName = null;
        if (session()->has('uploaded_video')) {
            $videoFileName = session()->get('uploaded_video');
            session()->forget('uploaded_video'); // Hapus dari session setelah diambil
        }

        SubMaterial::create([
            'id_material' => $idMaterial,
            'title' => $request->title,
            'description' => $request->description,
            'file_material' => $videoFileName, // Bisa null jika tidak ada video
            'file_pdf' => $pdfFileName,
        ]);

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