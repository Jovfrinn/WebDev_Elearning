<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('edit-profile.edit-profile', compact('user'));
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

        $user = Auth::user();

        if($request->hasFile('image')){
            $image = $request->file('image');
            $fileName = 'profile_image_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $image->move(public_path('assets/img'), $fileName);

            $user->update([
                'name' => $request->nama,
                'email' => $request->email,
                'image_profile' => $fileName,
            ]);
            return redirect()->back()->with('success', 'Profile Updated');
        }

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);
        return redirect()->back()->with('success', 'Profile Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
