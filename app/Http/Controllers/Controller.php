<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanRepoInterface;
use App\Services\Transaksi\Interfaces\Repositories\Transaksi as TransaksiRepoInterface;
use App\Repositories\Kendaraan\Repository as KendaraanRepo;
use App\Repositories\Motor\Repository as MotorRepo;
use App\Repositories\Mobil\Repository as MobilRepo;
use App\Repositories\Transaksi\Repository as TransaksiRepo;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getKendaraanRepository(string $vehicleType = '') : KendaraanRepoInterface {
        if($vehicleType == 'motor') {
            return new MotorRepo();
        }

        if($vehicleType == 'mobil') {
            return new MobilRepo();
        }

        return new KendaraanRepo();
    }

    protected function getTransaksiRepo() : TransaksiRepoInterface
    {
        return new TransaksiRepo();
    }

    protected function setJsonResponse($data, int $code, string $message = '') {
        if($code == 200) {
            $message = 'success';
        }else if ($message == ''){
            $message = 'failed';
        }

        if($data == null) {
            $data = [];
        }

        return response()->json([
            "status" => [
                "code" => $code,
                "message" => $message
            ],
            "data" => $data
        ])->setStatusCode($code);
    }
}
