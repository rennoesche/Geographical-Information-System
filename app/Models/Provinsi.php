<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';
    protected $fillable = ['nama', 'alt_name', 'latitude', 'longitude', 'boundary'];

    public function kabupaten()
    {
        return $this->hasMany(KabupatenKota::class);
    }
    public function setBoundaryAttribute($value)
    {
        $this->attributes['boundary'] = DB::raw("ST_GeomFromGeoJSON('{$value}')");
    }

    public function getBoundaryAttribute($value)
    {
        return DB::selectOne("SELECT ST_AsGeoJSON('{$value}') AS geojson")->geojson;
    }
    
}
