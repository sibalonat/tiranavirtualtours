<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Inertia\Inertia;
use App\Models\Station;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Landing/AllMenu');
    }

    public function tours()
    {
        return Inertia::render('Landing/Journeys', [
            'tours' => Tour::select('title', 'slug')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        // dd($tour->with('stations')->get());
        // 'tour' => $tour->with('stations')->select('description_al', 'description_en', 'title')->first()
        // dd($tour->with('stations')->first());
        return Inertia::render('Landing/SingleTour', [
            'tour' => $tour->with('stations')->first()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int Station $station
     * @return \Illuminate\Http\Response
     */
    public function showStation(Tour $tour, Station $station)
    {
        // dd($station->with('media'));
        return Inertia::render('Landing/SingleStation', [
            'station' => $station,
            'tour' => $tour,
            'featured' => $station->getFirstMedia('imgAudio')
        ]);
    }

}
