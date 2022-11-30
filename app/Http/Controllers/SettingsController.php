<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('Landing/Settings', [
            'settings' => Settings::first()
        ]);
    }

    public function put(Request $request)
    {

        return Redirect::route('landing.settings');
    }
}
