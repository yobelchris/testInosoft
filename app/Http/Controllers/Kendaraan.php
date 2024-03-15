<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\Kendaraan\Service as KendaraanService;

class Kendaraan extends Controller
{
    public function getKendaraanList(Request $request) {
        $vehicleType = $request->input('vehicle_type', '');

        $repo = $this->getKendaraanRepository($vehicleType);

        try {
            $vehicles = (new KendaraanService($repo))->getKendaraanList();

            return $this->setJsonResponse($vehicles, 200);
        }catch (Exception $e) {
            return $this->setJsonResponse($e, 500);
        }
    }

    public function updateKendaraanStock(Request $request) {
        $vehicleID = $request->input('vehicle_id', '');
        $addedStock = $request->input('vehicle_added_stock', 0);

        if($vehicleID == '') {
            return $this->setJsonResponse(null, 400, 'vehicle_id is empty');
        }

        if($addedStock == 0) {
            return $this->setJsonResponse(null, 200);
        }

        $repo = $this->getKendaraanRepository();

        $isSuccess = (new KendaraanService($repo))->updateKendaraanStok($vehicleID, $addedStock);
        if($isSuccess) {
            return $this->setJsonResponse(null, 200);
        }else{
            return $this->setJsonResponse(null, 500, 'stock update failed');
        }
    }
}
