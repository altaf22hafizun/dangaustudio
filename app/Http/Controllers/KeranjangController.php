<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::where('user_id', Auth::id())->with('karya')->get();
        return view('landing.cart.index', compact('pesanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'karya_id' => 'required|exists:karyas,id',
            'price' => 'required|numeric',
        ]);

        // Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        Pesanan::create([
            'user_id' => $userId,
            'karya_id' => $request->input('karya_id'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('cart.index')->with('success', 'Karya berhasil ditambahkan ke keranjang!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
