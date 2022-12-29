<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        // dd(!Settings::all()->isEmpty());
        $exists = Settings::all()->isEmpty();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'permissions' => [
                'audio' => !$exists ? Settings::first()->audio : null,
                'location' => !$exists ? Settings::first()->location : null,
                'ar' => !$exists ? Settings::first()->ar : null,
                'camera' => !$exists ? Settings::first()->camera : null,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
