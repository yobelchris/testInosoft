<?php
declare(strict_types=1);

namespace App\Repositories\Motor;

use App\Repositories\Kendaraan\Repository as KendaraanRepo;
use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Models\Motor as MotorServiceModel;

class Repository extends KendaraanRepo {
    public function get(int $offset = 0, int $limit = 0) : array {
        if($offset > 0 && $limit > 0) {
            $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'motor')->skip($offset)->take($limit);
        }else{
            $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'motor');
        }

        $results = [];

        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;
        $engineField = KendaraanModel::ENGINE_FIELD;
        $suspensionTypeField = KendaraanModel::SUSPENSION_TYPE_FIELD;
        $transmissionTypeField = KendaraanModel::TRANSMISSION_TYPE_FIELD;

        foreach ($data as $datum) {
            $results[] = new MotorServiceModel($datum->getIdAttribute(), $datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField, $datum->$engineField, $datum->$suspensionTypeField, $datum->$transmissionTypeField);
        }

        return $results;
    }
}
