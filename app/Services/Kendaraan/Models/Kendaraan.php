<?php
declare(strict_types=1);

namespace App\Services\Kendaraan\Models;

class Kendaraan {
    public string $id;
    public string $name;
    public string $vehicle_type;
    public int $year_of_release;
    public string $color;
    public float $price;
    public int $stock;

    public function __construct(string $id, string $name, string $vehicleType, int $year_of_release, string $color, float $price, int $stock) {
        $this->id = $id;
        $this->name = $name;
        $this->vehicle_type = $vehicleType;
        $this->year_of_release = $year_of_release;
        $this->color = $color;
        $this->price = $price;
        $this->stock = $stock;
    }
}
