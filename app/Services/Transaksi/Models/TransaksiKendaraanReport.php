<?php

namespace App\Services\Transaksi\Models;

use App\Services\Kendaraan\Models\Kendaraan;

class TransaksiKendaraanReport
{
    public float $total;
    public Kendaraan $vehicle;

    /**
     * @var Transaksi[] $transaction
    **/
    public array $transactions;
}
