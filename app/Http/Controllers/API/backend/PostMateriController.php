<?php

namespace App\Http\Controllers\API\backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostMateri;
use App\Models\Material;
use App\Models\MaterialUser;
use Illuminate\Http\Request;

class PostMateriController extends Controller
{
    public function index(){

        $materi = Material::all();

        $data["material"] = PostMateri::collection($materi);

        // if( auth()->check()){

        // $userId = auth()->id();

        // $idMateri = MaterialUser::where('id_user', $userId)->pluck('id_material');

        // $materialUser = Material::whereIn('id', $idMateri)->get();

        // $data["materialUser"] = PostMateri::collection($materialUser);

        // }
        
        return response()->json($data);
        
   
   
        //     try {
    //         $materi = Material::all();
    //         return PostMateri::collection($materi);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e], 500);
    //     }
    
    }
}
