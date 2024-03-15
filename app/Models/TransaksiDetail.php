<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $collection = 'transaksi_detail';

    const TRANSACTION_DETAIL_QUANTITY_FIELD = 'quantity';
    const TRANSACTION_DETAIL_TOTAL_FIELD = 'total';
    const TRANSACTION_DETAIL_VEHICLE_ID_FIELD = 'kendaraan_id';
    const TRANSACTION_ID_FIELD = 'transaksi_id';
}
