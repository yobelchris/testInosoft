<?php

namespace App\Services\Transaksi\Models;

class TransaksiDetail
{
    public string $id;
    public int $quantity;
    public float $total;
    public string $vehicle_id;
    public string $transaction_id;

    public function __construct(int $quantity, float $total, string $vehicleID, string $transactionID) {
        $this->quantity = $quantity;
        $this->total = $total;
        $this->vehicle_id = $vehicleID;
        $this->transaction_id = $transactionID;
    }
}
