<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Inertia\Inertia;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreStationRequest;

class StationController extends Controller
{
    public function editStation(Tour $tour, Station $station)
    {

        return Inertia::modal('Tour/ModalStation')
            ->with([
                'stat' => $station->only(
                    'id',
                    'slug',
                    'uuid',
                    'title_en',
                    'title_al',
                    'teaser_al',
                    'teaser_en',
                    'tour_id',
                    'lng',
                    'lat'),
                // 'media' => $station->media->all()
            ])
            ->baseRoute('tour.edit', $tour->slug);
    }

    public function update(StoreStationRequest $request, Tour $tour, Station $station)
    {
        $request->validated();
        $station->update($request->all());

        return Redirect::route('tour.edit', $tour->slug);
    }

    public function stationAudioImage(Request $request, Station $station)
    {
        if (isset($request->imgAudio)) {
            $station->addMediaFromRequest('imgAudio')->toMediaCollection('imgAudio');

            $st = $station->getMedia('imgAudio')->last();

            return response()->json($st);
        }
    }

    public function deleteFeature(Station $station, Request $request, $id)
    {
        $id = $request->id;

        $station->media->where('id', $id)->first()->delete();
    }

    public function createStation(Tour $tour)
    {
        return $this->initialstore($tour);
    }

    public function initialstore($tour)
    {
        $station = Station::create([
            'tour_id' => $tour->id
        ]);

        return Redirect::route('tour.stationmodal', [$tour->slug, $station->id]);
    }

    public function delete(Station $station)
    {
        $station->delete();
        return response()->json('done');
    }


        // api calls
        public function stationImage(Request $request, Station $station)
        {

            if (isset($request->stationArr)) {

                foreach ($request->files as $value) {
                    if ($value->getMimeType() === 'video/mp4') {
                        $station->addMediaFromRequest('stationArr')->toMediaCollection('videos');
                    } else if($value->getMimeType() === 'audio/mpeg') {
                        // audios
                        $station->addMediaFromRequest('stationArr')->toMediaCollection('audios');
                    } else {
                        $station->addMediaFromRequest('stationArr')->toMediaCollection('stationArr');
                    }
                }

                // $st = $station->select('id')->with('media')->first();
                $st = $station->with('media')->get();
                $medias = $st->map(function($item) {
                    $flatten = $item->getMedia('stationArr')->map(function($url) use($item) {
                        if ($url->mime_type === 'video/mp4') {
                            $resource = collect([$url]);
                            $media = $url->getUrl('thumb');
                            $finale = $resource->zip([$media])->concat([$item->title, $url->mime_type]);
                            return $finale->flatten(1);
                        } else if($url->mime_type === 'audio/mpeg') {
                        } else {
                            $resource = collect([$url]);
                            $media = $url->getUrl('thumbimg');
                            $finale = $resource->zip([$media])->concat([$item->title, $url->mime_type]);
                            return $finale->flatten(1);
                        }
                    });

                    return $flatten;
                });

                return response()->json($medias->flatten(1));
            }
        }


        public function stationImages(Station $station)
        {
            // $element = $station->media->all();
            $st = $station->with('media')->get();
            $medias = $st->map(function($item) {
                $flatten = $item->getMedia('stationArr')->map(function($url) use($item) {
                    if ($url->mime_type === 'video/mp4') {
                        $resource = collect([$url]);
                        $media = $url->getUrl('thumb');
                        $finale = $resource->zip([$media])->concat([$item->title, $url->mime_type]);
                        return $finale->flatten(1);
                    } else if($url->mime_type === 'audio/mp3') {
                    } else {
                        $resource = collect([$url]);
                        $media = $url->getUrl('thumbimg');
                        $finale = $resource->zip([$media])->concat([$item->title, $url->mime_type]);
                        return $finale->flatten(1);
                    }
                });

                return $flatten;
            });
            return response()->json($medias->flatten(1));
        }


}
