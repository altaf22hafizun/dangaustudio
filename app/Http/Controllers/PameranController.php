<?php

namespace App\Http\Controllers;

use App\Models\Pameran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PameranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pamerans = Pameran::where('status_publikasi', 'Published')->get();
        // return view('admin.pameran.index');
        return response()->json(['status' => 'success', 'message' => 'Data berhasil ditemukan', 'data' => $pamerans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pameran.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name_pameran' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status_publikasi' => 'required|string|in:Published,Hidden',
        ], [
            'name_pameran.required' => 'Nama pameran wajib diisi.',
            'name_pameran.string' => 'Nama pameran harus berupa teks.',
            'name_pameran.max' => 'Nama pameran tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi pameran wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'start_date.required' => 'Tanggal mulai pameran wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'end_date.required' => 'Tanggal akhir pameran wajib diisi.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',

            'image.required' => 'Gambar pameran wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

            'status_publikasi.required' => 'Status publikasi wajib diisi.',
            'status_publikasi.string' => 'Status publikasi harus berupa teks.',
            'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pameran', 'public');
            $validateData['image'] = $imagePath;
        }

        // Membuat slug dari judul event
        $slug = Str::slug($request->name_pameran);
        $validateData['slug'] = $slug;

        $pamerans = new Pameran($validateData);
        $pamerans->setNameAttribute($validateData['name_pameran']);
        $pamerans->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pameran berhasil ditambahkan',
            'data' => $pamerans,
        ]);

        // return redirect()->route('admin.pameran.index')->with('success', 'Data pameran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pameran $pameran, string $slug)
    {
        $pamerans = Pameran::where('slug', $slug)->firstOrFail();
        return view('user.pameran.show', compact('pamerans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pamerans = Pameran::findOrFail($id);
        return view('admin.pameran.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pamerans = Pameran::findOrFail($id);
        $validateData = $request->validate([
            'name_pameran' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status_publikasi' => 'required|string|in:Published,Hidden',
        ], [
            'name_pameran.required' => 'Nama pameran wajib diisi.',
            'name_pameran.string' => 'Nama pameran harus berupa teks.',
            'name_pameran.max' => 'Nama pameran tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi pameran wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'start_date.required' => 'Tanggal mulai pameran wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'end_date.required' => 'Tanggal akhir pameran wajib diisi.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',

            'image.required' => 'Gambar pameran wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

            'status_publikasi.required' => 'Status publikasi wajib diisi.',
            'status_publikasi.string' => 'Status publikasi harus berupa teks.',
            'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
        ]);

        if ($request->hasFile('image')) {
            if ($pamerans->image) {
                Storage::delete(['public' => $pamerans->image]);
            }
            $imagePath = $request->file('image')->store('pameran', 'public');
            $validateData['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar baru, jangan hapus gambar lama
            unset($validateData['image']); // Menjaga nilai gambar lama tetap di database
        }

        // Membuat slug dari judul event
        $slug = Str::slug($request->name_pameran);
        $validateData['slug'] = $slug;

        Pameran::where('id', $id)->update($validateData);
        // return redirect()->route('admin.pameran.index')->with('Data pameran berhasil diperbarui');
        return response()->json(['status' => 'success', 'message' => 'Data pameran berhasil diperbarui', 'data' => $validateData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pamerans = Pameran::findOrFail($id);
        $pamerans->delete();

        // return redirect()->route('admin.pameran.index')->with('Data pameran berhasil dihapus');
        return response()->json(['status' => 'success', 'message' => 'Data pameran berhasil dihapus']);
    }
}
