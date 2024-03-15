<?php
declare(strict_types=1);

namespace App\Services\Kendaraan;

use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanRepo;
use function Sodium\add;

class Service
{
    private KendaraanRepo $kendaraanRepo;

    public function __construct(KendaraanRepo $kendaraanRepo) {
        $this->kendaraanRepo = $kendaraanRepo;
    }

    public function getKendaraanList(int $offset = 0, int $limit = 0) : array {
        return $this->kendaraanRepo->get($offset, $limit);
    }

    public function updateKendaraanStok(string $vehicleID, int $addedStock) : bool {
        return $this->kendaraanRepo->addStock($vehicleID, $addedStock);
    }
}
