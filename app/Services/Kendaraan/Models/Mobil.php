<?php

namespace App\Services\Kendaraan\Models;

class Mobil extends Kendaraan
{
    public string $engine;
    public int $passenger_capacity;
    public string $type;

    public function __construct(string $id, string $vehicleType, int $year_of_release, string $color, float $price, int $stock, string $engine, int $passenger_capacity, string $type) {
        parent::__construct($id, $vehicleType, $year_of_release, $color, $price, $stock);
        $this->engine = $engine;
        $this->passenger_capacity = $passenger_capacity;
        $this->type = $type;
    }
}
