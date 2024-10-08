<?php

namespace App\Http\Controllers;

use App\Models\Karya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.karya.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validateData = $request->validate([
            'seniman_id' => 'required|exists:senimans,id', // Pastikan seniman ada di database
            'pameran_id' => 'nullable|exists:pamerans,id', // Pameran bersifat opsional
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'medium' => 'required|string',
            'size' => 'required|string',
            'tahun' => 'required|integer|digits:4',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|integer|min:0',
        ], [
            'seniman_id.required' => 'Seniman wajib diisi.',
            'seniman_id.exists' => 'Seniman tidak ditemukan.',
            'pameran_id.exists' => 'Pameran tidak ditemukan.',
            'name.required' => 'Nama karya wajib diisi.',
            'name.max' => 'Nama karya tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi karya wajib diisi.',
            'medium.required' => 'Medium karya wajib diisi.',
            'size.required' => 'Size karya wajib diisi.',
            'tahun.required' => 'Tahun karya wajib diisi.',
            'price.required' => 'Harga karya wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'category.required' => 'Kategori karya wajib diisi.',
            'category.max' => 'Kategori tidak boleh lebih dari 255 karakter.',
            'image.required' => 'Gambar karya wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'stock.required' => 'Stok karya wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok minimal adalah 0.',
        ]);

        // Jika ada file gambar yang diunggah, simpan ke dalam folder 'public/karya'
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('karya', 'public');
            $validateData['image'] = $imagePath;
        }

        // Simpan data karya
        $karyas = Karya::create($validateData);
        $karyas->setNameAttribute($validateData['name']);
        $karyas->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Karya berhasil ditambahkan',
            'data' => $karyas,
        ]);

        // return redirect()->route('admin.karya.index')->with('success', 'Data karya berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karya $karya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyas = Karya::findOrFail($id);
        return view('admin.karya.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyas = Karya::findOrFail($id);
        $validateData = $request->validate([
            'seniman_id' => 'required|exists:senimans,id', // Pastikan seniman ada di database
            'pameran_id' => 'nullable|exists:pamerans,id', // Pameran bersifat opsional
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'medium' => 'required|string',
            'size' => 'required|string',
            'tahun' => 'required|integer|digits:4',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|integer|min:0',
        ], [
            'seniman_id.required' => 'Seniman wajib diisi.',
            'seniman_id.exists' => 'Seniman tidak ditemukan.',
            'pameran_id.exists' => 'Pameran tidak ditemukan.',
            'name.required' => 'Nama karya wajib diisi.',
            'name.max' => 'Nama karya tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi karya wajib diisi.',
            'medium.required' => 'Medium karya wajib diisi.',
            'size.required' => 'Size karya wajib diisi.',
            'tahun.required' => 'Tahun karya wajib diisi.',
            'price.required' => 'Harga karya wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'category.required' => 'Kategori karya wajib diisi.',
            'category.max' => 'Kategori tidak boleh lebih dari 255 karakter.',
            'image.required' => 'Gambar karya wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'stock.required' => 'Stok karya wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok minimal adalah 0.',
        ]);

        if ($request->hasFile('image')) {
            if ($karyas->image) {
                Storage::delete(['public' => $karyas->image]);
            }
            $imagePath = $request->file('image')->store('karya', 'public');
            $validateData['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar baru, jangan hapus gambar lama
            unset($validateData['image']); // Menjaga nilai gambar lama tetap di database
        }

        Karya::where('id', $id)->update($validateData);
        // return redirect()->route('admin.karya.index')->with('Data karya berhasil diperbarui');
        return response()->json(['status' => 'success', 'message' => 'Data karya berhasil diperbarui', 'data' => $validateData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karya $karya, string $id)
    {
        $karyas = Karya::findOrFail($id);
        $karyas->delete();

        // return redirect()->route('admin.karya.index')->with('Data karya berhasil dihapus');
        return response()->json(['status' => 'success', 'message' => 'Data karya berhasil dihapus']);
    }
}
