<?php
declare(strict_types=1);

namespace App\Repositories\Mobil;

use App\Repositories\Kendaraan\Repository as KendaraanRepo;
use App\Models\Kendaraan as KendaraanModel;
use App\Services\Kendaraan\Models\Kendaraan as KendaraanServiceModel;
use App\Services\Kendaraan\Models\Mobil;
use App\Services\Kendaraan\Models\Mobil as MobilServiceModel;

class Repository extends KendaraanRepo{
    public function get(int $offset, int $limit) : array {
        $data = KendaraanModel::all()->where(KendaraanModel::VEHICLE_TYPE_FIELD, 'mobil');

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
        $passengerField = KendaraanModel::PASSENGER_CAPACITY_FIELD;
        $typeField = KendaraanModel::TYPE_FIELD;

        foreach ($data as $datum) {
            $results[] = new MobilServiceModel($datum->getIdAttribute(), $datum->$nameField, $datum->$vehicleTypeField, $datum->$yearOfReleaseField, $datum->$colorField, $datum->$priceField, $datum->$stokField, $datum->$engineField, $datum->$passengerField, $datum->$typeField);
        }

        return $results;
    }

    /**
     * @param MobilServiceModel $vehicleData
    **/
    public function insertVehicle($vehicleData): bool
    {
        $vehicleTypeField = KendaraanModel::VEHICLE_TYPE_FIELD;
        $yearOfReleaseField = KendaraanModel::YEAR_OF_RELEASE_FIELD;
        $nameField = KendaraanModel::VEHICLE_NAME_FIELD;
        $colorField = KendaraanModel::COLOR_FIELD;
        $priceField = KendaraanModel::PRICE_FIELD;
        $stokField = KendaraanModel::STOK_FIELD;
        $engineField = KendaraanModel::ENGINE_FIELD;
        $passengerField = KendaraanModel::PASSENGER_CAPACITY_FIELD;
        $typeField = KendaraanModel::TYPE_FIELD;

        $vehicle = new KendaraanModel();
        $vehicle->$vehicleTypeField = $vehicleData->vehicle_type;
        $vehicle->$yearOfReleaseField = $vehicleData->year_of_release;
        $vehicle->$nameField = $vehicleData->name;
        $vehicle->$colorField = $vehicleData->color;
        $vehicle->$priceField = $vehicleData->price;
        $vehicle->$stokField = $vehicleData->stock;
        $vehicle->$engineField = $vehicleData->engine;
        $vehicle->$passengerField = $vehicleData->passenger_capacity;
        $vehicle->$typeField = $vehicleData->type;

        return $vehicle->save();
    }
}
