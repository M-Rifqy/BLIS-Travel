<?php

namespace App\Http\Controllers\Client\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller

{
    public function index(Activity $activity)
    {
        return view('pages.client.activity.index', compact('activity'));
    }
}

