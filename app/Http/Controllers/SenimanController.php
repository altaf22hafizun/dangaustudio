<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SenimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $senimans = Seniman::all();
        foreach ($senimans as $seniman) {
            // Memproses URL media sosial yang disimpan di properti 'medsos'
            // Fungsi rtrim() menghapus karakter '/' yang mungkin ada di akhir URL
            // Fungsi basename() mengambil bagian terakhir dari URL (misalnya, nama pengguna dari URL media sosial)
            $seniman->medsos_name = basename(rtrim($seniman->medsos, '/'));
        }
        return view('admin.seniman.index', compact('senimans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.seniman.create');
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

        // return response()->json([
        //     'message' => 'Data seniman berhasil disimpan.',
        //     'data' => $seniman,
        // ]);

        return redirect()->route('admin.seniman.index')->with('success', 'Data seniman berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $paket = Seniman::find($id);
        // if (!$paket) {
        //     return response()->json(['status' => 'false', 'message' => 'Data gagal ditemukan']);
        // } else {
        //     return response()->json(['status' => 'true', 'message' => 'Data berhasil ditemukan', 'data' => $paket]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $senimans = Seniman::findOrFail($id);

        return view('admin.seniman.edit', compact('senimans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

        // Temukan seniman berdasarkan ID
        $senimans = Seniman::findOrFail($id);

        // Jika ada file foto_profile baru yang diunggah
        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($senimans->foto_profile) {
                Storage::delete('public/' . $senimans->foto_profile);
            }

            // Upload foto baru
            $imagePath = $request->file('foto_profile')->store('seniman', 'public');
            $validatedData['foto_profile'] = $imagePath;
        }

        Seniman::where('id', $id)->update($validatedData);
        return redirect()->route('admin.seniman.index')->with('Data seniman berhasil diperbarui');
        // return response()->json(['status' => 'success', 'message' => 'Data seniman berhasil diperbarui', 'data' => $validatedData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $senimans = Seniman::findOrFail($id);
        $senimans->delete();

        return redirect()->route('admin.seniman.index')->with('Data seniman berhasil dihapus');
        // return response()->json(['status' => 'success', 'message' => 'Data seniman berhasil dihapus']);
    }
}
