<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\MapController;

Route::get('/', function () {
    return view('beranda');
});

Route::get('/beranda', [BerandaController::class, 'index']) ->name('beranda');
Route::get('/map', [MapController::class, 'index']);
Route::get('/map/kabkota/{id}', [MapController::class, 'getKabkota']);

Route::get('/gempa', function() {

    $xml = simplexml_load_file('https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.xml');

    $gempaData = [];
    foreach ($xml-> gempa as $gempa) {
        $coordinates = explode(",", (string) $gempa->point->coordinates);
        $gempaData[] = [
            'tanggal' => (string) $gempa->Tanggal,
            'jam' => (string) $gempa->Jam,
            'lintang' => (string) $gempa->Lintang,
            'bujur' => (string) $gempa->Bujur,
            'magnitudo' => (string) $gempa->Magnitude,
            'kedalaman' => (string) $gempa->Kedalaman,
            'wilayah' => (string) $gempa->Wilayah,
            'potensi' => (string) $gempa->Potensi,
            'latitude' => (float) $coordinates[0],
            'longitude' => (float) $coordinates[1],
        ];
} return view('gempa',  ['gempaData' => $gempaData]);
});
