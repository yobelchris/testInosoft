<?php
declare(strict_types=1);

namespace App\Services\Kendaraan\Interfaces\Repositories;

interface Kendaraan
{
    public function get(int $offset = 0, int $limit = 0) : array;
    public function addStock(string $id, int $addedStock) : bool;
}
