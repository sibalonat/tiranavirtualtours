<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTourRequest;
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
            'title' => $request->title
        ]);
        return Redirect::route('tour.edit', $tour->slug);
    }

    public function edit(Tour $tour)
    {

        return Inertia::render('Tours/TourEditWithStations', [
            'tour' => $tour->whereId($tour->id)->with('stations')->first(),
        ]);
    }

}
