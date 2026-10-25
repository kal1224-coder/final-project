<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement; // <-- ይህ መስመር መኖሩን ያረጋግጡ!

class GuestController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->take(5)->get();
        return view('guest.index', compact('announcements'));
    }
}