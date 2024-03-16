<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\Kendaraan\Service as KendaraanService;
use App\Services\Kendaraan\Models\Motor as MotorModel;
use App\Services\Kendaraan\Models\Mobil as MobilModel;

class Kendaraan extends Controller
{
    public function getKendaraanList(Request $request) {
        $vehicleType = $request->input('vehicle_type', '');

        $repo = $this->getKendaraanRepository($vehicleType);

        try {
            $vehicles = (new KendaraanService($repo))->getKendaraanList();

            return $this->setJsonResponse($vehicles, 200);
        }catch (Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }
    }

    public function addKendaraanMotor(Request $request) {
        $repo = $this->getKendaraanRepository('motor');

        $KendaraanModel = new MotorModel('',
            $request->input('name', ''),
            $request->input('vehicle_type', ''),
            $request->input('year_of_release',0),
            $request->input('color',''),
            $request->input('price', 0),
            $request->input('stock',0),
            $request->input('engine',''),
            $request->input('suspension_type',''),
            $request->input('transmission_type',''));

        try {
            $isSuccess = (new KendaraanService($repo))->addKendaraanMotor($KendaraanModel);

            if(!$isSuccess) {
                return $this->setJsonResponse(null, 500, 'add motor failed');
            }
        }catch (Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }

        return $this->setJsonResponse(null, 200);
    }

    public function addKendaraanMobil(Request $request) {
        $repo = $this->getKendaraanRepository('mobil');

        $KendaraanModel = new MobilModel('',
            $request->input('name', ''),
            $request->input('vehicle_type', ''),
            $request->input('year_of_release',0),
            $request->input('color',''),
            $request->input('price', 0),
            $request->input('stock',0),
            $request->input('engine',''),
            $request->input('passenger_capacity',0),
            $request->input('type',''));

        try {
            $isSuccess = (new KendaraanService($repo))->addKendaraanMobil($KendaraanModel);

            if(!$isSuccess) {
                return $this->setJsonResponse(null, 500, 'add mobil failed');
            }
        }catch (Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }

        return $this->setJsonResponse(null, 200);
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
