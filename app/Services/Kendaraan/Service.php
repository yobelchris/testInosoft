<?php
declare(strict_types=1);

namespace App\Services\Kendaraan;

use App\Services\Error;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanRepo;

use App\Services\Kendaraan\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Models\Mobil as MobilModel;
use App\Services\Kendaraan\Models\Motor as MotorModel;

class Service
{
    private KendaraanRepo $kendaraanRepo;

    public function __construct(KendaraanRepo $kendaraanRepo) {
        $this->kendaraanRepo = $kendaraanRepo;
    }

    public function addKendaraanMotor(MotorModel $kendaraan) : bool {
        return $this->kendaraanRepo->insertVehicle($kendaraan);
    }

    public function addKendaraanMobil(MobilModel $kendaraan) : bool {
        return $this->kendaraanRepo->insertVehicle($kendaraan);
    }

    public function getKendaraanList(int $offset = 0, int $limit = 0) : array {
        return $this->kendaraanRepo->get($offset, $limit);
    }

    public function updateKendaraanStok(string $vehicleID, int $addedStock) : bool {
        return $this->kendaraanRepo->addStock($vehicleID, $addedStock);
    }
}
