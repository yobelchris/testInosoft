<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Transaksi\Service as TransaksiService;

use App\Services\Transaksi\Models\Transaksi as TransaksiModel;
use App\Services\Transaksi\Models\TransaksiDetail as TransaksiDetailModel;

class Transaksi extends Controller
{
    public function insertTransaction(Request $request)
    {
        $transactionNumber = $request->input('transaction_number', '');

        try{
            $transactionDate = $request->date('transaction_date', 'Y-m-d H:i:s');
        }catch (\Exception $e) {
            return $this->setJsonResponse(null, 400, 'wrong transaction_date format');
        }

        if($transactionDate == null){
            $transactionDate = new \DateTime();
        }

        $customerName = $request->input('customer_name', '');

        $transaction = new TransaksiModel($transactionNumber, $transactionDate, 0.0, $customerName, '1');
        $transaction->transaksiDetail = [];

        $transactionDetails = $request->input('details');

        if(!is_array($transactionDetails) || count($transactionDetails) <= 0) {
            return $this->setJsonResponse(null, 400, 'details is empty');
        }

        $alreadyExistedVehicleID = [];
        foreach ($transactionDetails as $detail) {
            if(!array_key_exists('quantity', $detail) || $detail['quantity'] <= 0) {
                return $this->setJsonResponse(null, 400, 'details quantity is empty');
            }

            if(!array_key_exists('total', $detail) || $detail['total'] <= 0) {
                return $this->setJsonResponse(null, 400, 'details total is empty');
            }

            if(!array_key_exists('vehicle_id', $detail) || $detail['vehicle_id'] == '') {
                return $this->setJsonResponse(null, 400, 'details vehicle_id is empty');
            }

            if(in_array($detail['vehicle_id'], $alreadyExistedVehicleID)) {
                return $this->setJsonResponse(null, 400, 'vehicle_id '.$detail['vehicle_id'].' is duplicated in details');
            }

            $alreadyExistedVehicleID[] = $detail['vehicle_id'];

            $transaction->transaksiDetail[] = new TransaksiDetailModel('',$detail['quantity'], $detail['total'], $detail['vehicle_id'], '');
            $transaction->total = $transaction->total + $detail['total'];
        }

        $kendaraanRepo = $this->getKendaraanRepository();
        $transaksiRepo = $this->getTransaksiRepo();

        try{
            $isInsertSuccess = (new TransaksiService($transaksiRepo, $kendaraanRepo))->insertTransaction($transaction, $transaction->transaksiDetail);

            if($isInsertSuccess != null) {
                return $this->setJsonResponse(null, 500, $isInsertSuccess->message);
            }
        }catch (\Exception $e){
            return $this->setJsonResponse($e, 500, $e->getMessage());
        }

        return $this->setJsonResponse(null, 200);
    }

    public function getTransaction(Request $request) {
        $customerName = $request->input('customer_name', '');
        $transactionNumber = $request->input('transaction_number', '');

        $kendaraanRepo = $this->getKendaraanRepository();
        $transaksiRepo = $this->getTransaksiRepo();

        try{
            $transactions = (new TransaksiService($transaksiRepo, $kendaraanRepo))->getTransaction($customerName,$transactionNumber, '');

            return $this->setJsonResponse($transactions, 200);
        }catch (\Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }
    }

    public function getTransactionDetail(Request $request) {
        $transactionID = $request->input('transaction_id', '');

        if($transactionID == '') {
            return $this->setJsonResponse(null, 400, 'transaction_id is required');
        }

        $kendaraanRepo = $this->getKendaraanRepository();
        $transaksiRepo = $this->getTransaksiRepo();

        try{
            $transactions = (new TransaksiService($transaksiRepo, $kendaraanRepo))->getTransactionDetail($transactionID);

            return $this->setJsonResponse($transactions, 200);
        }catch (\Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }
    }

    public function getTransactionReport(Request $request) {
        $vehicleID = $request->input('vehicle_id', '');
        $vehicleType = $request->input('vehicle_type', '');

        $kendaraanRepo = $this->getKendaraanRepository($vehicleType);
        $transaksiRepo = $this->getTransaksiRepo();

        try{
            $reports = (new TransaksiService($transaksiRepo, $kendaraanRepo))->getTransactionReport($vehicleID);

            return $this->setJsonResponse($reports, 200);
        }catch (\Exception $e) {
            return $this->setJsonResponse(null, 500, $e->getMessage());
        }
    }
}
