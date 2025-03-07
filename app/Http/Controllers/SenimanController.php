<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SenimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function landing()
    {
        $senimans = Seniman::orderBy('name', 'asc')->pencarian()->paginate(12);
        foreach ($senimans as $seniman) {
            // Memproses URL media sosial yang disimpan di properti 'medsos'
            // Fungsi rtrim() menghapus karakter '/' yang mungkin ada di akhir URL
            // Fungsi basename() mengambil bagian terakhir dari URL (misalnya, nama pengguna dari URL media sosial)
            $seniman->medsos_name = basename(rtrim($seniman->medsos, '/'));
        }
        return view('landing.seniman.index', compact('senimans'));
    }

    public function index()
    {
        $senimans = Seniman::orderBy('name', 'asc')->pencarian()->paginate(5);
        $title = 'Hapus Seniman!';
        $text = "Apakah kamu ingin menghapus seniman tersebut?";
        confirmDelete($title, $text);
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
            'telp' => 'nullable|string|min:10',
            'medsos' => 'nullable|url',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'bio.required' => 'Bio wajib diisi.',
            'bio.string' => 'Bio harus berupa teks.',

            // 'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.string' => 'Nomor telepon harus berupa string.',
            'telp.min' => 'Nomor telepon minimal 10 karakter.',

            'medsos.required' => 'Medsos wajib diisi.',
            'medsos.url' => 'Format URL media sosial tidak valid.',

            'foto_profile.required' => 'Foto profile wajib diisi.',
            'foto_profile.image' => 'File foto profil harus berupa gambar.',
            'foto_profile.mimes' => 'Gambar harus berformat jpg, jpeg, atau png.',
            'foto_profile.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('foto_profile')) {
            $imagePath = $request->file('foto_profile')->store('seniman', 'public');
            $validatedData['foto_profile'] = $imagePath;
        }

        // Membuat slug dari name
        $slug = Str::slug($request->name);
        $validatedData['slug'] = $slug;

        // Membuat objek seniman baru
        $seniman = new Seniman($validatedData);

        // Menggunakan setter untuk format nama
        $seniman->setNameSenimanAtributes($validatedData['name']);

        // Menyimpan data seniman ke database
        $seniman->save();

        return redirect()->route('seniman.index')->with('success', 'Data seniman berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $senimans = Seniman::where('slug', $slug)->firstOrFail();
        $senimans->medsos_name = basename(rtrim($senimans->medsos, '/'));
        $karyas = $senimans->karyas()->paginate(9);

        return view('landing.seniman.detail', compact('senimans', 'karyas'));
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
            'telp' => 'nullable|string|min:10',
            'medsos' => 'nullable|url',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'bio.required' => 'Bio wajib diisi.',
            'bio.string' => 'Bio harus berupa teks.',

            // 'telp.required' => 'Nomor telepon wajib diisi.',
            'telp.string' => 'Nomor telepon harus berupa string.',
            'telp.min' => 'Nomor telepon minimal 10 karakter.',

            'medsos.required' => 'Medsos wajib diisi.',
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
        } else {
            // Jika tidak ada gambar baru, jangan hapus gambar lama
            unset($validatedData['foto_profile']); // Menjaga nilai gambar lama tetap di database
        }

        // Membuat slug dari name
        $slug = Str::slug($request->name);
        $validatedData['slug'] = $slug;

        Seniman::where('id', $id)->update($validatedData);
        return redirect()->route('seniman.index')->with('success', 'Data seniman berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $senimans = Seniman::findOrFail($id);
        $senimans->delete();

        return redirect()->route('seniman.index')->with('success', 'Data seniman berhasil dihapus');
    }
}
