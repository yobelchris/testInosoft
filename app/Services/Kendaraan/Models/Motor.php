<?php
declare(strict_types=1);

namespace App\Services\Kendaraan\Models;

class Motor extends Kendaraan
{
    public string $engine;
    public string $suspension_type;
    public string $transmission_type;

    public function __construct(string $id, string $vehicleType, int $year_of_release, string $color, float $price, int $stock, string $engine, string $suspension_type, string $transmission_type) {
        parent::__construct($id, $vehicleType, $year_of_release, $color, $price, $stock);
        $this->engine = $engine;
        $this->suspension_type = $suspension_type;
        $this->transmission_type = $transmission_type;
    }
}
