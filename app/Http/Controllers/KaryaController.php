<?php

namespace App\Http\Controllers;

use App\Models\Karya;
use App\Models\Pameran;
use App\Models\Seniman;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function landing()
    {
        // $karyas = Karya::orderBy('name', 'ASC')->pencarian()->paginate(12);
        // return view('landing.galery.index', compact('karyas'));

        // Ambil kategori medium yang unik dari tabel karya
        $categories = Karya::select('medium')->distinct()->get();

        // Ambil daftar tahun yang unik dari kolom 'tahun'
        $years = Karya::select('tahun')->distinct()->orderByDesc('tahun')->pluck('tahun');

        $stock = Karya::select('stock')->distinct()->get();

        // Ambil karya yang sesuai dengan filter
        $karyas = Karya::query()
            ->pencarian()
            ->paginate(12);

        // Mengirimkan data kategori medium, tahun dan karya ke view
        return view('landing.galery.index', compact('categories', 'years', 'karyas', 'stock'));
    }

    public function index()
    {
        $karyas = Karya::whereIn('stock', ['Tersedia', 'Terjual'])->latest()->pencarian()->paginate(5);
        // Ambil seniman dan pameran yang relevan
        $senimanIds = $karyas->pluck('seniman_id')->unique();
        $pameranIds = $karyas->pluck('pameran_id')->unique();

        $senimans = Seniman::whereIn('id', $senimanIds)->get();
        $pamerans = Pameran::whereIn('id', $pameranIds)->get();
        $title = 'Hapus Karya!';
        $text = "Apakah kamu ingin menghapus karya tersebut?";
        confirmDelete($title, $text);
        return view('admin.galery.index', compact('karyas', 'senimans', 'pamerans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $senimans = Seniman::orderBy('name', 'asc')->get();
        $pamerans = Pameran::where('status_publikasi', 'Published')->orderBy('name_pameran', 'asc')->get();
        return view('admin.galery.create', compact('senimans', 'pamerans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validateData = $request->validate([
            'seniman_id' => 'required|exists:senimen,id',
            'pameran_id' => 'nullable|exists:pamerans,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'price' => 'required|numeric|min:0',
            // 'category' => 'required|string|max:255',
            'medium' => 'required|string',
            'size' => 'required|string',
            'tahun' => 'required|integer|digits:4',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            // 'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|string|in:Terjual,Tersedia',
        ], [
            'seniman_id.required' => 'Seniman wajib diisi.',
            'seniman_id.exists' => 'Seniman tidak ditemukan.',
            'pameran_id.exists' => 'Pameran tidak ditemukan.',
            'name.required' => 'Nama karya wajib diisi.',
            'name.max' => 'Nama karya tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi karya wajib diisi.',
            'medium.required' => 'Medium karya wajib diisi.',
            'size.required' => 'Size karya wajib diisi.',
            'tahun.required' => 'Tahun karya wajib diisi.',
            'price.required' => 'Harga karya wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            // 'category.required' => 'Kategori karya wajib diisi.',
            // 'category.max' => 'Kategori tidak boleh lebih dari 255 karakter.',
            'image.required' => 'Gambar karya wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format jpg, jpeg, atau png.',
            // 'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'stock.required' => 'Stock karya wajib diisi.',
            'stock.string' => 'Stock karya harus berupa teks.',
            'stock.in' => 'Stock karya harus salah satu dari: Tersedia atau Terjual.',
        ]);

        // Jika ada file gambar yang diunggah, simpan ke dalam folder 'public/karya'
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('karya', 'public');
            $validateData['image'] = $imagePath;
        }

        // Membuat slug dari judul karya
        $slug = Str::slug($request->name);
        $validateData['slug'] = $slug;

        // Simpan data karya
        $karyas = Karya::create($validateData);
        $karyas->setNameAttribute($validateData['name']);
        $karyas->save();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Karya berhasil ditambahkan',
        //     'data' => $karyas,
        // ]);

        return redirect()->route('karya.index')->with('success', 'Data karya berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $karya = Karya::where('slug', $slug)->firstOrFail();
        $seniman = $karya->seniman;
        return view('landing.galery.detail', compact('karya', 'seniman'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyas = Karya::findOrFail($id);
        $senimans = Seniman::orderBy('name', 'asc')->get();
        $pamerans = Pameran::where('status_publikasi', 'Published')->orderBy('name_pameran', 'asc')->get();
        $stock = [
            'Terjual' => 'Terjual',
            'Tersedia' => 'Tersedia',
        ];
        return view('admin.galery.edit', compact('karyas', 'senimans', 'pamerans', 'stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyas = Karya::findOrFail($id);
        $validateData = $request->validate([
            'seniman_id' => 'required|exists:senimen,id',
            'pameran_id' => 'nullable|exists:pamerans,id',
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'price' => 'required|numeric|min:0',
            // 'category' => 'required|string|max:255',
            'medium' => 'required|string',
            'size' => 'required|string',
            'tahun' => 'required|integer|digits:4',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'stock' => 'required|string|in:Terjual,Tersedia',

        ], [
            'seniman_id.required' => 'Seniman wajib diisi.',
            'seniman_id.exists' => 'Seniman tidak ditemukan.',
            'pameran_id.exists' => 'Pameran tidak ditemukan.',
            'name.required' => 'Nama karya wajib diisi.',
            'name.max' => 'Nama karya tidak boleh lebih dari 255 karakter.',
            'deskripsi.required' => 'Deskripsi karya wajib diisi.',
            'medium.required' => 'Medium karya wajib diisi.',
            'size.required' => 'Size karya wajib diisi.',
            'tahun.required' => 'Tahun karya wajib diisi.',
            'price.required' => 'Harga karya wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            // 'category.required' => 'Kategori karya wajib diisi.',
            // 'category.max' => 'Kategori tidak boleh lebih dari 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format jpg, jpeg, atau png.',
            // 'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
            'stock.required' => 'Stock karya wajib diisi.',
            'stock.string' => 'Stock karya harus berupa teks.',
            'stock.in' => 'Stock karya harus salah satu dari: Tersedia atau Terjual.',
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

        $slug = Str::slug($request->name);
        $validateData['slug'] = $slug;

        Karya::where('id', $id)->update($validateData);
        return redirect()->route('karya.index')->with('Data karya berhasil diperbarui');
        // return response()->json(['status' => 'success', 'message' => 'Data karya berhasil diperbarui', 'data' => $validateData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $karyas = Karya::findOrFail($id);
        if ($karyas->image) {
            Storage::delete('public/' . $karyas->image);
        }
        $karyas->delete();

        return redirect()->route('karya.index')->with('success', 'Data karya berhasil dihapus');
        // return response()->json(['status' => 'success', 'message' => 'Data karya berhasil dihapus']);
    }
}
