<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\KabupatenKota;

class MapController extends Controller
{
    public function index()
    {
        $provinsis = Provinsi::all();
        return view('map.index', compact('provinsis'));
    }

    public function getKabkota($id)
    {
        $kabupaten = KabupatenKota::where('provinsi_id', $id)->get();
        return response()->json($kabupaten);
    }
}
