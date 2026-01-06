<?php

namespace App\Http\Controllers\Client\Home;

use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function home()
    {
        $participants = Participant::latest()->get();
        return view('pages.client.home.index', compact('participants'));
    }
}
