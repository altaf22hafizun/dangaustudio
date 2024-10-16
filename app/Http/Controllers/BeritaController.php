<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function landing()
    {
        return view('landing.berita.index');
    }

    public function index()
    {
        $beritas = Berita::whereIn('status_publikasi', ['Published', 'Hidden'])->latest()->paginate(3);
        $title = 'Hapus Berita!';
        $text = "Apakah kamu ingin menghapus berita tersebut?";
        confirmDelete($title, $text);
        return view('admin.berita.index', compact('beritas'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'tgl' => 'required|date|',
                // 'penulis' => 'nullable|string|max:255',
                'sumber_berita' => 'nullable|string',
                'label_berita' => 'nullable|string',
                'link_berita' => 'nullable|url',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'status_publikasi' => 'required|string|in:Published,Hidden',
            ],
            [
                'name.required' => 'Nama berita tidak boleh kosong',
                'name.string' => 'Nama berita harus berupa teks.',
                'name.max' => 'Nama berita tidak boleh lebih dari 255 karakter.',

                'description.required' => 'Deskripsi berita tidak boleh kosong',
                'description.string' => 'Deskripsi berita harus',

                'tgl.required' => 'Tanggal publikasi berita harus diisi',
                'tgl.date' => 'Tanggal publikasi berita harus berupa tanggal yang valid.',

                'image.required' => 'Gambar berita wajib diunggah.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

                'link_berita.url' => 'Link berita harus berupa URL yang valid.',

                'status_publikasi.required' => 'Status publikasi wajib diisi.',
                'status_publikasi.string' => 'Status publikasi harus berupa teks.',
                'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
            ]
        );

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('berita', 'public');
            $validateData['image'] = $imagePath;
        }

        // Membuat slug dari judul berita
        $slug = Str::slug($request->name);
        $validateData['slug'] = $slug;

        $beritas = new Berita($validateData);
        $beritas->setNameBeritaAttribute($validateData['name']);
        $beritas->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Data berita berhasil ditambahkan',
        //     'data' => $beritas,
        // ]);
        return redirect()->route('berita.index')->with('success', 'Data berita berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita, $slug)
    {
        $beritas = Berita::where('slug', $slug)->firstOrFail();
        return view('user.berita.show', compact('beritas'));
        // if (!$beritas) {
        //     return response()->json(['status' => 'false', 'message' => 'Data gagal ditemukan']);
        // } else {
        //     return response()->json(['status' => 'true', 'message' => 'Data berhasil ditemukan', 'data' => $beritas]);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $beritas = Berita::findOrFail($id);
        $status_publikasi = [
            'Published' => 'Published',
            'Hidden' => 'Hidden',
        ];

        return view('admin.berita.edit', compact('beritas', 'status_publikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $beritas = Berita::findOrFail($id);
        $validateData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'tgl' => 'required|date',
                // 'penulis' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'sumber_berita' => 'nullable|string',
                'label_berita' => 'nullable|string',
                'link_berita' => 'nullable|url',
                'status_publikasi' => 'required|string|in:Published,Hidden',
            ],
            [
                'name.required' => 'Nama berita tidak boleh kosong',
                'name.string' => 'Nama berita harus berupa teks.',
                'name.max' => 'Nama berita tidak boleh lebih dari 255 karakter.',

                'description.required' => 'Isi berita tidak boleh kosong',
                'description.string' => 'Isi berita harus berupa teks.',

                'tgl.required' => 'Tanggal publikasi berita harus diisi',
                'tgl.date' => 'Tanggal publikasi berita harus berupa tanggal yang valid.',

                // 'image.required' => 'Gambar berita wajib diunggah.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
                'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

                'link_berita.url' => 'Link berita harus berupa URL yang valid.',

                'status_publikasi.required' => 'Status publikasi wajib diisi.',
                'status_publikasi.string' => 'Status publikasi harus berupa teks.',
                'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
            ]
        );

        if ($request->hasFile('image')) {
            if ($beritas->image) {
                Storage::delete('public/' . $beritas->image); // Memperbaiki path
            }

            $imagePath = $request->file('image')->store('berita', 'public');
            $validateData['image'] = $imagePath;
        } else {
            unset($validateData['image']); // Menjaga nilai gambar lama tetap di database
        }


        // Membuat slug dari judul berita
        $slug = Str::slug($request->name);
        $validateData['slug'] = $slug;

        Berita::where('id', $id)->update($validateData);
        return redirect()->route('berita.index')->with('success', 'Data berita berhasil diperbarui');
        // return response()->json(['status' => 'success', 'message' => 'Data berita berhasil diperbarui', 'data' => $validateData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $beritas = Berita::findOrFail($id);

        if ($beritas->image) {
            // Hapus gambar dari storage
            Storage::delete('public/' . $beritas->image);
        }
        $beritas->delete();

        return redirect()->route('berita.index')->with('success', 'Data berita berhasil dihapus');
        // return response()->json(['status' => 'success', 'message' => 'Data berita berhasil dihapus']);
    }
}
