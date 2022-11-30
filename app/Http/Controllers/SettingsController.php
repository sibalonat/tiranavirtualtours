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

    public function update(Request $request)
    {
        $settings = Settings::first();
        switch ($request->t) {
            case 'camera':
                $settings->update(['camera' => $request->camera]);
                break;
            case 'audio':
                $settings->update(['audio' => $request->audio]);
                break;
            case 'ar':
                $settings->update(['ar' => $request->ar]);
                break;
            case 'location':
                $settings->update(['location' => $request->location]);
                break;
            default:
                # code...
                break;
        }

        return Redirect::route('landing.settings');
    }
}
