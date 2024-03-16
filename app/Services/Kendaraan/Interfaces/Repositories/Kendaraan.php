<?php
declare(strict_types=1);

namespace App\Services\Kendaraan\Interfaces\Repositories;

use App\Services\Kendaraan\Models\Kendaraan as KendaraanServiceModel;
use App\Services\Kendaraan\Models\Mobil as MobilServiceModel;
use App\Services\Kendaraan\Models\Motor as MotorServiceModel;

interface Kendaraan
{
    public function get(int $offset, int $limit) : array;
    public function addStock(string $id, int $addedStock) : bool;
    public function getByID(string $id) : KendaraanServiceModel|null;
    public function insertVehicle($vehicleData) : bool;
}
