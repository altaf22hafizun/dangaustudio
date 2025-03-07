<?php

namespace App\Http\Controllers;

use App\Models\Pameran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PameranController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function landing()
    {
        $pamerans = Pameran::whereIn('status_publikasi', ['Published'])->latest()->pencarian()->paginate(12);
        return view('landing.pameran.index', compact('pamerans'));
    }

    public function index()
    {
        $pamerans = Pameran::whereIn('status_publikasi', ['Published', 'Hidden'])->latest()->pencarian()->paginate(5);
        $title = 'Hapus Pameran!';
        $text = "Apakah kamu ingin menghapus pameran tersebut?";
        confirmDelete($title, $text);
        return view('admin.pameran.index', compact('pamerans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pameran.create');
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

        // Membuat slug dari judul pameran
        $slug = Str::slug($request->name_pameran);
        $validateData['slug'] = $slug;

        $pamerans = new Pameran($validateData);
        $pamerans->setNameAttribute($validateData['name_pameran']);
        $pamerans->save();

        return redirect()->route('pameran.index')->with('success', 'Data pameran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pameran $pameran, string $slug)
    {
        $pamerans = Pameran::where('slug', $slug)->firstOrFail();
        $pamerans->start_date = Carbon::parse($pamerans->start_date)->format('d F Y');
        $pamerans->end_date = Carbon::parse($pamerans->end_date)->format('d F Y');
        $karyas = $pamerans->karyas()->with('seniman')->paginate(12);
        return view('landing.pameran.detail', compact('pamerans', 'karyas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pamerans = Pameran::findOrFail($id);
        $status_publikasi = [
            'Published' => 'Published',
            'Hidden' => 'Hidden',
        ];
        return view('admin.pameran.edit', compact('pamerans', 'status_publikasi'));
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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
        return redirect()->route('pameran.index')->with('success', 'Data pameran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pamerans = Pameran::findOrFail($id);
        if ($pamerans->image) {
            Storage::delete('public/' . $pamerans->image);
        }
        $pamerans->delete();


        return redirect()->route('pameran.index')->with('success', 'Data pameran berhasil dihapus');
    }
}
