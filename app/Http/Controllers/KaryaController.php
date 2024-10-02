<?php

namespace App\Http\Controllers;

use App\Models\Karya;
use Illuminate\Http\Request;

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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|integer|min:0',
        ], [
            'seniman_id.required' => 'Seniman wajib diisi.',
            'seniman_id.exists' => 'Seniman tidak ditemukan.',
            'pameran_id.exists' => 'Pameran tidak ditemukan.',
            'name.required' => 'Nama karya wajib diisi.',
            'name.max' => 'Nama karya tidak boleh lebih dari 255 karakter.',
            'description.required' => 'Deskripsi karya wajib diisi.',
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
    public function edit(Karya $karya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karya $karya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karya $karya)
    {
        //
    }
}
