<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Event;
use App\Models\Karya;
use App\Models\Pameran;
use App\Models\Seniman;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function admin()
    {
        $senimanCount = Seniman::count();
        $karyaSeniCount = Karya::where('stock', 'Tersedia')->count();
        $eventCount = Pameran::where('status_publikasi', 'Published')->count();
        $userCount = User::where('role', 'user')->count();


        $upcomingEvents = Event::where('start_date', '>=', now())
            ->where('status_publikasi', 'Published')
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.index', compact('upcomingEvents', 'senimanCount', 'karyaSeniCount', 'userCount', 'eventCount'));
    }

    public function adminUser()
    {
        $users = User::where('role', 'user')
            ->whereNotNull('email_verified_at')
            ->latest()
            ->paginate(5);
        return view('admin.user.index', compact('users'));
    }

    public function index()
    {
        //Karya
        $karyas = Karya::where('stock', 'Tersedia')->inRandomOrder()->take(12)->get();
        $senimanIds = $karyas->pluck('seniman_id')->unique();
        $senimans = Seniman::whereIn('id', $senimanIds)->get();

        //pameran
        $pamerans = Pameran::where('status_publikasi', 'Published')->take(6)->get();
        //event
        $events = Event::where('status_publikasi', 'Published')->take(6)->get();
        //berita
        $beritas = Berita::where('status_publikasi', 'Published')->take(6)->get();

        //seniman
        $senimans = Seniman::inRandomOrder()->take(12)->get();
        foreach ($senimans as $seniman) {
            $seniman->medsos_name = basename(rtrim($seniman->medsos, '/'));
        }
        return view('landing.index', compact('senimans', 'karyas', 'pamerans', 'events', 'beritas'));
    }
    public function tentang()
    {
        return view('landing.tentang.index');
    }
}
