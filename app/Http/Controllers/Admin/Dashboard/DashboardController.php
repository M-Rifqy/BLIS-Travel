<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\Activity;
use App\Models\Document;
use App\Models\Participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        $participants = Participant::all();

        return view('pages.admin.dashboard.index', compact('activities', 'participants'));
    }
}
