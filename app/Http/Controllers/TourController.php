<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTourRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class TourController extends Controller
{
    public function index()
    {
        return Inertia::render('Tours/IndexTours', [
            'tours' => Tour::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Tours/TourCreate');
    }

    public function store(StoreTourRequest $request)
    {
        $request->validated();
        $tour = Tour::create([
            'title' => $request->title,
            'description_al' => $request->description_al,
            'description_en' => $request->description_en,
        ]);
        return Redirect::route('tour.edit', $tour->slug);
    }

    public function edit(Tour $tour)
    {
        return Inertia::render('Tours/TourEditWithStations', [
            'tour' => $tour->whereId($tour->id)->with('stations')->first(),
            'data_station' => Session::get('station')
        ]);
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return Redirect::route('app.tours');
    }

}
