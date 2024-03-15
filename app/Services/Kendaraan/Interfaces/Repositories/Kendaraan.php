<?php
declare(strict_types=1);

namespace App\Services\Kendaraan\Interfaces\Repositories;

use App\Services\Kendaraan\Models\Kendaraan as KendaraanServiceModel;

interface Kendaraan
{
    public function get(int $offset = 0, int $limit = 0) : array;
    public function addStock(string $id, int $addedStock) : bool;
    public function getByID(string $id) : KendaraanServiceModel|null;
}
