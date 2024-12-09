<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $materi = Material::all();

        $data["material"] = $materi;

        if( auth()->check()){

        $userId = auth()->id();

        $idMateri = MaterialUser::where('id_user', $userId)->pluck('id_material');

        $materialUser = Material::whereIn('id', $idMateri)->get();

        $data["materialUser"] = $materialUser;

        }

        return view('home', $data);
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
        $idUser = Auth::id();
        $idMaterial = $id;
    
        $materi = MaterialUser::where('id', $id)
        ->where('id_user', $idUser)
        ->where('id_material', $idMaterial)
        ->first();





        if ($materi) {
        return redirect()->route('sub.materi', $idMaterial);
        }

        $joined = MaterialUser::create([
            'id_user' => $idUser,
            'id_material' => $idMaterial,
            'joined_at' => now(),
        ]);

        $joined->save();

        return redirect()->route('sub.materi',$idMaterial);
        

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
