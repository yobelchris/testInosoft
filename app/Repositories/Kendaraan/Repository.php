<?php
declare(strict_types=1);

namespace App\Repositories\Kendaraan;

use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanInterface;
use App\Services\Kendaraan\Models\Kendaraan as KendaraanServiceModel;

class Repository implements KendaraanInterface{
    public function get(int $offset, int $limit) : array {
        $data = KendaraanModel::all();

        if($offset > 0 && $limit > 0) {
            $data = $data->skip($offset)->take($limit);
        }

        $results = [];

        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $nameField = KendaraanModel::VEHICLE_NAME_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;

        foreach ($data as $datum) {
            $results[] = new KendaraanServiceModel($datum->getIdAttribute(), $datum->$nameField, $datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField);
        }

        return $results;
    }

    public function getByID(string $id) : KendaraanServiceModel|null {
        $data = KendaraanModel::all()->where("_id", $id);

        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $nameField = KendaraanModel::VEHICLE_NAME_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;

        foreach ($data as $datum) {
            return new KendaraanServiceModel($datum->getIdAttribute(), $datum->$nameField, $datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField);
        }

        return null;
    }

    public function addStock(string $id, int $addedStock) : bool {
        $vehicles = KendaraanModel::all()->where('_id', $id);

        foreach ($vehicles as $vehicle) {
            $vehicle->stok = $vehicle->stok + $addedStock;

            return $vehicle->save();
        }
    }
}
