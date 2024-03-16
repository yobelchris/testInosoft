<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $collection = 'kendaraan';

    const VEHICLE_TYPE_FIELD = 'vehicle_type';
    const VEHICLE_NAME_FIELD = 'vehicle_name';
    const TYPE_FIELD = 'type';
    const ENGINE_FIELD = 'mesin';
    const SUSPENSION_TYPE_FIELD = 'tipe_suspensi';
    const TRANSMISSION_TYPE_FIELD = 'tipe_transmisi';
    const PASSENGER_CAPACITY_FIELD = 'kapasitas_penumpang';
    const PRICE_FIELD = 'harga';
    const YEAR_OF_RELEASE_FIELD = 'tahun_keluaran';
    const COLOR_FIELD = 'warna';
    const STOK_FIELD = 'stok';
}
