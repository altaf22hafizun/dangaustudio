<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use Illuminate\Http\Request;

class SenimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $senimans = Seniman::all();
        foreach ($senimans as $seniman) {
            $seniman->medsos_name = basename(rtrim($seniman->medsos, '/'));
        }
        return view('admin.seniman.index', compact('senimans'));
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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string',
            'telp' => 'required|string|min:10',
            'medsos' => 'nullable|url',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'bio.required' => 'Bio wajib diisi.',
            'bio.string' => 'Bio harus berupa teks.',

            'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.string' => 'Nomor telepon harus berupa string.',
            'telp.min' => 'Nomor telepon minimal 10 karakter.',

            'medsos.url' => 'Format URL media sosial tidak valid.',

            'foto_profile.image' => 'File foto profil harus berupa gambar.',
            'foto_profile.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'foto_profile.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('foto_profile')) {
            $imagePath = $request->file('foto_profile')->store('seniman', 'public');
            $validatedData['foto_profile'] = $imagePath;
        }

        // Membuat objek seniman baru
        $seniman = new Seniman($validatedData);

        // Menggunakan setter untuk format nama
        $seniman->setNameSenimanAtributes($validatedData['name']);

        // Menyimpan data seniman ke database
        $seniman->save();

        return response()->json([
            'message' => 'Data seniman berhasil disimpan.',
            'data' => $seniman,
        ]);

        // return redirect()->route('admin.seniman.index')->with('success', 'Data seniman berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seniman $seniman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seniman $seniman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seniman $seniman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seniman $seniman)
    {
        //
    }
}
