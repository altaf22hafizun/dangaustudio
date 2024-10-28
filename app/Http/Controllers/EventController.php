<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function landing(Event $event)
    {
        $events = Event::orderBy('start_date', 'ASC')->latest()->pencarian()->paginate(12);

        return view('landing.event.index', compact('events'));
    }

    public function index()
    {
        $events = Event::whereIn('status_publikasi', ['Published', 'Hidden'])->orderBy('start_date', 'ASC')->latest()->pencarian()->paginate(5);
        $title = 'Hapus Event!';
        $text = "Apakah kamu ingin menghapus event tersebut?";
        confirmDelete($title, $text);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'status_publikasi' => 'required|string|in:Published,Hidden',
        ], [
            'nama_event.required' => 'Nama event wajib diisi.',
            'nama_event.string' => 'Nama event harus berupa teks.',
            'nama_event.max' => 'Nama event tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi event wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'location.required' => 'Lokasi event wajib diisi.',
            'location.string' => 'Lokasi harus berupa teks.',

            'category.required' => 'Kategori event wajib diisi.',
            'category.string' => 'Kategori harus berupa teks.',

            'start_date.required' => 'Tanggal mulai event wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'end_date.required' => 'Tanggal akhir event wajib diisi.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',

            'image.required' => 'Gambar event wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

            'status_publikasi.required' => 'Status publikasi wajib diisi.',
            'status_publikasi.string' => 'Status publikasi harus berupa teks.',
            'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $validateData['image'] = $imagePath;
        }

        // Membuat slug dari judul event
        $slug = Str::slug($request->nama_event);
        $validateData['slug'] = $slug;

        $event = new Event($validateData);
        $event->setNameEventAttribute($validateData['nama_event']);
        // $event->setLocationEventAttribute($validateData['location']);
        $event->setCategoryEventAttribute($validateData['category']);
        $event->save();

        return redirect()->route('events.index')->with('success', 'Data event berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $events = Event::where('slug', $slug)->firstOrFail();
        $events->start_date = Carbon::parse($events->start_date)->format('d F Y');
        $events->end_date = Carbon::parse($events->end_date)->format('d F Y');
        return view('landing.event.detail', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $events = Event::findOrFail($id);
        $status_publikasi = [
            'Published' => 'Published',
            'Hidden' => 'Hidden',
        ];

        return view('admin.events.edit', compact('events', 'status_publikasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $events = Event::findOrFail($id);
        $validateData = $request->validate([
            'nama_event' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_publikasi' => 'required|string|in:Published,Hidden',
        ], [
            'nama_event.required' => 'Nama event wajib diisi.',
            'nama_event.string' => 'Nama event harus berupa teks.',
            'nama_event.max' => 'Nama event tidak boleh lebih dari 255 karakter.',

            'description.required' => 'Deskripsi event wajib diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'location.required' => 'Lokasi event wajib diisi.',
            'location.string' => 'Lokasi harus berupa teks.',

            'category.required' => 'Kategori event wajib diisi.',
            'category.string' => 'Kategori harus berupa teks.',

            'start_date.required' => 'Tanggal mulai event wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'end_date.required' => 'Tanggal akhir event wajib diisi.',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',

            // 'image.required' => 'Gambar event wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus dalam format: jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2 MB.',

            'status_publikasi.required' => 'Status publikasi wajib diisi.',
            'status_publikasi.string' => 'Status publikasi harus berupa teks.',
            'status_publikasi.in' => 'Status publikasi harus salah satu dari: Published atau Hidden.',
        ]);

        if ($request->hasFile('image')) {
            if ($events->image) {
                Storage::delete(['public' . $events->image]);
            }

            $imagePath = $request->file('image')->store('event', 'public');
            $validateData['image'] = $imagePath;
        } else {
            // Jika tidak ada gambar baru, jangan hapus gambar lama
            unset($validateData['image']); // Menjaga nilai gambar lama tetap di database
        }

        // Membuat slug dari judul event
        $slug = Str::slug($request->nama_event);
        $validateData['slug'] = $slug;

        Event::where('id', $id)->update($validateData);
        return redirect()->route('events.index')->with('success', 'Data event berhasil diperbarui');
        // return response()->json(['status' => 'success', 'message' => 'Data event berhasil diperbarui', 'data' => $validateData]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $events = Event::findOrFail($id);
        $events->delete();

        return redirect()->route('events.index')->with('success', 'Data event berhasil dihapus');
        // return response()->json(['status' => 'success', 'message' => 'Data event berhasil dihapus']);
    }
}
