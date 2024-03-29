<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
// use Illuminate\Foundation\Application;
use App\Http\Controllers\TourController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// virtual tours
Route::get('tours', [TourController::class, 'index'])->middleware(['auth', 'verified'])->name('app.tours');
Route::get('tours/create', [TourController::class, 'create'])->middleware(['auth', 'verified'])->name('tour.create');
// Route::get('tours/{tour:slug}', [TourController::class, 'show'])->middleware(['auth', 'verified'])->name('tour.show');
Route::post('tours', [TourController::class, 'store'])->middleware(['auth', 'verified'])->name('tour.store');
Route::get('tours/edit/{tour:slug}', [TourController::class, 'edit'])->middleware(['auth', 'verified'])->name('tour.edit');
Route::put('tours/{tour:slug}/update', [
    TourController::class, 'edit'
])->middleware(['auth', 'verified'])->name('tour.update');
Route::delete('tours/{tour}', [TourController::class, 'destroy'])->middleware(['auth', 'verified'])->name('tour.delete');

// stations
Route::get('tours/{tour:slug}/create-station', [StationController::class, 'createStation'])->middleware(['auth', 'verified'])->name('tour.redirect');
Route::get('tours/{tour:slug}/edit-station/{station}', [StationController::class, 'editStation'])->middleware(['auth', 'verified'])->name('tour.stationmodal');
// apiIndex
Route::get('tours/{tour}/all', [StationController::class, 'apiIndex'])->middleware(['auth', 'verified'])->name('tours.all');
Route::put('tours/{tour:slug}/edit-station/{station}', [StationController::class, 'update'])->middleware(['auth', 'verified'])->name('tour.stationupdate');
// feature delete
Route::post('single/{station}/img', [StationController::class, 'stationAudioImage'])->middleware(['auth', 'verified'])->name('tour.featureimg');
Route::post('single/{station}/threeobject', [StationController::class, 'stationThreeDObject'])->middleware(['auth', 'verified'])->name('tour.threeobject');
Route::get('single/{station}/feature', [StationController::class, 'stationFeatured'])->middleware(['auth', 'verified'])->name('tour.featureget');
Route::get('single/{station}/threeobject', [StationController::class, 'stationThread'])->middleware(['auth', 'verified'])->name('tour.threadget');
Route::delete('single/{station}/img/{id}', [StationController::class, 'deleteFeature'])->middleware(['auth', 'verified'])->name('tour.delfeature');
Route::delete('single/{station}/threeobject/{id}', [StationController::class, 'deleteObject'])->middleware(['auth', 'verified'])->name('tour.delmodel');

Route::get('single/{station}', [StationController::class, 'showStation'])->middleware(['auth', 'verified'])->name('single.station');
// Route::get('single/{station}', [StationController::class, 'showStation'])->middleware(['auth', 'verified'])->name('single.station');
// api delete
Route::delete('single/{station}/delete', [StationController::class, 'delete'])->middleware(['auth', 'verified'])->name('station.delete');


// api station img
Route::post('single/{station}/image-store', [StationController::class, 'stationImage'])->middleware(['auth', 'verified'])->name('station.storeimg');
Route::delete('single/{station}/images/{id}', [StationController::class, 'deleteStationImg'])->middleware(['auth', 'verified'])->name('station.imgdel');
Route::get('single/{station}/images', [StationController::class, 'stationImages'])->middleware(['auth', 'verified'])->name('station.imgsget');
Route::get('si/{station}/images', [StationController::class, 'showstationImages'])->middleware(['auth', 'verified'])->name('station.ims');
// Route::get('tours/{tour:slug}/create-dialog', [TourController::class, 'createDialog'])->middleware(['auth', 'verified'])->name('tour.stationdialog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Landing
// Route::get('start', [LandingController::class, 'start'])->middleware(['auth', 'verified'])->name('start.app');
Route::get('about', [LandingController::class, 'about'])->name('landing.about');
Route::get('landing', [LandingController::class, 'index'])->name('landing.all');
// Route::get('journeys', [LandingController::class, 'tours'])->middleware(['auth', 'verified'])->name('landing.tours');
Route::get('journeys', [LandingController::class, 'tours'])->name('landing.tours');
Route::get('journeys/{tour:slug}', [LandingController::class, 'show'])->name('landing.tourone');
Route::get('journeys/{tour:slug}/station/{station}', [LandingController::class, 'showStation'])->name('landing.stationone');
Route::get('journeys/{tour:slug}/st/{station}', [LandingController::class, 'showStationDesktop'])->name('stationone.desktop');
//setings route and configuration


require __DIR__.'/auth.php';
