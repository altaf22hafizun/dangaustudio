<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return response()->json([
            'success' => true,
            'data' => $events,
        ]);
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
            $imagePath = $request->file('image')->store('uploads', 'public');
            $validateData['image'] = $imagePath;
        }

        $event = Event::create($validateData);

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dibuat.',
            'data' => $event // Mengembalikan data event yang baru saja dibuat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
