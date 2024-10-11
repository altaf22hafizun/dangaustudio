<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        return view('landing.index');
    }
    public function tentang()
    {
        return view('landing.tentang.index');
    }
}
