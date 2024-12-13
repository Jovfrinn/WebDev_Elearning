<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\SubMaterial;
use Illuminate\Http\Request;

class SubMateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $idMateri = $id;

        $subMaterial = SubMaterial::where('id_material', $idMateri)->get();
        $data['subMaterial'] = $subMaterial;
        
        
        $materi = Material::findOrFail($idMateri);
        $data['materi'] = $materi;


        return view('materi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


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
        $detailMateri = SubMaterial::findOrFail($id);

        $data['detailMateri'] = $detailMateri;

        return view('detailMateri',$data);
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
