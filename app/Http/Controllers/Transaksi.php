<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\Transaksi\Service as TransaksiService;
use App\Services\Transaksi\Interfaces\Repositories\Transaksi as TransaksiRepoInterface;

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

            $transaction->transaksiDetail[] = new TransaksiDetailModel($detail['quantity'], $detail['total'], $detail['vehicle_id'], '');
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
            return $this->setJsonResponse($e, 500, 'insert failed');
        }

        return $this->setJsonResponse(null, 200);
    }
}
