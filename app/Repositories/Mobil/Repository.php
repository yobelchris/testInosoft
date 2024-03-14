<?php
declare(strict_types=1);

namespace App\Repositories\Mobil;

use App\Repositories\Kendaraan\Repository as KendaraanRepo;
use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Models\Mobil as MobilServiceModel;

class Repository extends KendaraanRepo{
    public function get(int $offset = 0, int $limit = 0) : array {
        if($offset > 0 && $limit > 0) {
            $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'mobil')->skip($offset)->take($limit);
        }else{
            $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'mobil');
        }

        $results = [];

        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;
        $engineField = KendaraanModel::ENGINE_FIELD;
        $passengerField = KendaraanModel::PASSENGER_CAPACITY_FIELD;
        $typeField = KendaraanModel::TYPE_FIELD;

        foreach ($data as $datum) {
            $results[] = new MobilServiceModel($datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField, $datum->$engineField, $datum->$passengerField, $datum->$typeField);
        }

        return $results;
    }
}
