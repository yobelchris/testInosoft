<?php
declare(strict_types=1);

namespace App\Repositories\Kendaraan;

use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanInterface;
use App\Services\Kendaraan\Models\Kendaraan as KendaraanServiceModel;

class Repository implements KendaraanInterface{
    public function get(int $offset = 0, int $limit = 0) : array {
        if($offset > 0 && $limit > 0) {
            $data = KendaraanModel::skip($offset)->take($limit)->get();
        }else{
            $data = KendaraanModel::all();
        }

        $results = [];

        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;

        foreach ($data as $datum) {
            $results[] = new KendaraanServiceModel($datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField);
        }

        return $results;
    }
}
