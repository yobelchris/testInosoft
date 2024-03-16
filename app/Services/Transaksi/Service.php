<?php

namespace App\Services\Transaksi;

use App\Services\Error;
use App\Services\Transaksi\Interfaces\Repositories\Transaksi as TransaksiRepo;
use App\Services\Kendaraan\Interfaces\Repositories\Kendaraan as KendaraanRepo;

use App\Services\Transaksi\Models\Transaksi as TransaksiModel;
use App\Services\Transaksi\Models\TransaksiDetail as TransaksiDetailModel;
use Illuminate\Support\Facades\DB;

class Service
{
    private TransaksiRepo $transaksiRepo;
    private KendaraanRepo $kendaraanRepo;

    public function __construct(TransaksiRepo $transaksiRepo, KendaraanRepo $kendaraanRepo) {
        $this->transaksiRepo = $transaksiRepo;
        $this->kendaraanRepo = $kendaraanRepo;
    }

    private function generateRandomUppercaseLetters($length) {
        $uppercaseLetters = '';
        for ($i = 0; $i < $length; $i++) {
            $asciiValue = rand(65, 90);
            $uppercaseLetters = $uppercaseLetters.chr($asciiValue);
        }
        return $uppercaseLetters;
    }

    /**
     * @param TransaksiModel $transaksi
     * @param TransaksiDetailModel[] $transaksiDetail
     */
    public function insertTransaction(TransaksiModel $transaksi, array $transaksiDetail) : Error|null {
        foreach ($transaksiDetail as $detail) {
            if(!$detail instanceof TransaksiDetailModel) {
                return new Error('wrong detail instance');
            }
        }

        if($transaksi->transaction_number == '') {
            $transaksi->transaction_number = 'TRX/'.$this->generateRandomUppercaseLetters(6).'/'.$transaksi->transaction_date->format('dYm');
        }

        $savedTransaksi = $this->transaksiRepo->insertTransaction($transaksi);

        if (is_bool($savedTransaksi) && !$savedTransaksi) {
            return new Error('insert transaction failed');
        }

        $createdDetailsIDs = [];
        $updatedVehicleStock = [];
        foreach ($transaksiDetail as $detail) {
            $vehicle = $this->kendaraanRepo->getByID($detail->vehicle_id);

            if($vehicle == null) {
                $this->transaksiRepo->deleteTransactionByID($savedTransaksi->id);
                if(count($createdDetailsIDs) > 0) {
                    $this->transaksiRepo->deleteTransactionDetailByIDs($createdDetailsIDs);
                }
                foreach ($updatedVehicleStock as $vehicleID => $addedStock) {
                    $this->kendaraanRepo->addStock($vehicleID, $addedStock);
                }
                return new Error('vehicle id '.$detail->vehicle_id.' not found');
            }

            $detail->transaction_id = $savedTransaksi->id;
            $savedTransaksiDetail = $this->transaksiRepo->insertTransactionDetails($detail);

            if(is_bool($savedTransaksiDetail) && !$savedTransaksiDetail) {
                $this->transaksiRepo->deleteTransactionByID($savedTransaksi->id);
                if(count($createdDetailsIDs) > 0) {
                    $this->transaksiRepo->deleteTransactionDetailByIDs($createdDetailsIDs);
                }
                foreach ($updatedVehicleStock as $vehicleID => $addedStock) {
                    $this->kendaraanRepo->addStock($vehicleID, $addedStock);
                }
                return new Error('insert transaction detail failed');
            }

            $createdDetailsIDs[] = $savedTransaksiDetail->id;

            $isStockUpdateSuccess = $this->kendaraanRepo->addStock($detail->vehicle_id, -$detail->quantity);

            if(!$isStockUpdateSuccess) {
                $this->transaksiRepo->deleteTransactionByID($savedTransaksi->id);
                if(count($createdDetailsIDs) > 0) {
                    $this->transaksiRepo->deleteTransactionDetailByIDs($createdDetailsIDs);
                }
                foreach ($updatedVehicleStock as $vehicleID => $addedStock) {
                    $this->kendaraanRepo->addStock($vehicleID, $addedStock);
                }
                return new Error('update vehicle stock failed');
            }

            $updatedVehicleStock[$detail->vehicle_id] = $detail->quantity;
        }

        return null;
    }

    public function getTransaction(string $customerName, string $userID) : array {
        return $this->transaksiRepo->getTransaction($customerName, $userID);
    }

    public function getTransactionDetail(string $transactionID) : array {
        return $this->transaksiRepo->getTransactionDetail($transactionID);
    }
}
