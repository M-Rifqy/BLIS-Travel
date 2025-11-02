<?php

namespace App\Http\Controllers\Client\Gallery;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index(Activity $activity)
    {
        $galleries = $activity->galleries()->get();
        return view('pages.client.gallery.index', compact('activity', 'galleries'));
    }
}
