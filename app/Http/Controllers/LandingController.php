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
        return Inertia::render('Landing/SingleTour', [
            'tour' => $tour->whereId($tour->id)->with('stations')->first()
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
        $st = Station::whereId($station->id)->first();

        $flattenimg = $st->getMedia('stationArr')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumbimg');
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenvideos = $st->getMedia('videos')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumb');
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenaudios = $st->getMedia('audios')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = null;
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenthread = $st->getMedia('threeDObject')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = null;
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });
        // dd($flattenthread);
        // dd($flattenaudios);

        if (!$flattenvideos->isEmpty() && !$flattenimg->isEmpty() && $flattenaudios->isEmpty()) {
            $collection = $flattenimg->concat($flattenvideos);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        } else if (!$flattenaudios->isEmpty() && $flattenvideos->isEmpty()) {
            $collection = $flattenimg->concat($flattenaudios);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        } else {
            $collection = $flattenimg->concat($flattenvideos)->concat($flattenaudios);
            // dd($collection);
            return Inertia::render('Landing/SingleStation', [
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        }
    }

        /**
     * Display the specified resource.
     *
     * @param  int Station $station
     * @return \Illuminate\Http\Response
     */
    public function showStationDesktop(Tour $tour, Station $station)
    {
        $st = Station::whereId($station->id)->first();

        $flattenimg = $st->getMedia('stationArr')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumbimg');
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenvideos = $st->getMedia('videos')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = $url->getUrl('thumb');
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenaudios = $st->getMedia('audios')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = null;
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        $flattenthread = $st->getMedia('threeDObject')->map(function ($url) use ($st) {
            $resource = collect([$url]);
            $media = null;
            $finale = $resource->zip([$media])->concat([$st->title, $url->mime_type]);
            return $finale->flatten(1);
        });

        if (!$flattenvideos->isEmpty() && !$flattenimg->isEmpty() && $flattenaudios->isEmpty()) {
            $collection = $flattenimg->concat($flattenvideos);
            // 'station' => Inertia::lazy(fn () => $station),
            return response()->json([
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        } else if (!$flattenaudios->isEmpty() && $flattenvideos->isEmpty()) {
            $collection = $flattenimg->concat($flattenaudios);
            return response()->json([
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        } else {
            $collection = $flattenimg->concat($flattenvideos)->concat($flattenaudios);
            return response()->json([
                'station' => $st,
                'tour' => $tour,
                'featured' => $st->getFirstMedia('imgAudio'),
                'media_collection' => $collection,
                'thread' => $flattenthread,
            ]);
        }
    }


    public function about()
    {
        return inertia('Landing/About');
    }

}
