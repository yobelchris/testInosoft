<?php
declare(strict_types=1);

namespace App\Repositories\Motor;

use App\Repositories\Kendaraan\Repository as KendaraanRepo;
use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Models\Motor as MotorServiceModel;

class Repository extends KendaraanRepo {
    public function get(int $offset, int $limit) : array {
        $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'motor');

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
        $engineField = KendaraanModel::ENGINE_FIELD;
        $suspensionTypeField = KendaraanModel::SUSPENSION_TYPE_FIELD;
        $transmissionTypeField = KendaraanModel::TRANSMISSION_TYPE_FIELD;

        foreach ($data as $datum) {
            $results[] = new MotorServiceModel($datum->getIdAttribute(), $datum->$nameField, $datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField, $datum->$engineField, $datum->$suspensionTypeField, $datum->$transmissionTypeField);
        }

        return $results;
    }
}
