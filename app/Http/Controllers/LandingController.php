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
    public function start()
    {
        return Inertia::render('Landing/Start');
    }

    /**
     * Display initial page.
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

        $flattenimg = $station->getMedia('stationArr')->map(function ($url) use ($station) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumbimg');
            $finale = $resource->zip([$media])->concat([$station->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenvideos = $station->getMedia('videos')->map(function ($url) use ($station) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumb');
            $finale = $resource->zip([$media])->concat([$station->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenaudios = $station->getMedia('audios')->map(function ($url) use ($station) {
            $resource = collect([$url]);
            $media = null;
            $finale = $resource->zip([$media])->concat([$station->title, $url->mime_type]);
            return $finale->flatten(1);
        });
        // dd($flattenaudios);

        if (!$flattenvideos->isEmpty() && !$flattenimg->isEmpty() && $flattenaudios->isEmpty()) {
            $collection = $flattenimg->concat($flattenvideos);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $station,
                'tour' => $tour,
                'featured' => $station->getFirstMedia('imgAudio'),
                'media_collection' => $collection
            ]);
        } else if (!$flattenaudios->isEmpty() && $flattenvideos->isEmpty()) {
            $collection = $flattenimg->concat($flattenaudios);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $station,
                'tour' => $tour,
                'featured' => $station->getFirstMedia('imgAudio'),
                'media_collection' => $collection
            ]);
        } else {
            $collection = $flattenimg->concat($flattenvideos)->concat($flattenaudios);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $station,
                'tour' => $tour,
                'featured' => $station->getFirstMedia('imgAudio'),
                'media_collection' => $collection
            ]);
        }
    }
}
