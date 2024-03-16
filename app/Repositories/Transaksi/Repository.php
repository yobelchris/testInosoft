<?php

namespace App\Repositories\Transaksi;

use App\Services\Transaksi\Interfaces\Repositories\Transaksi;
use App\Models\Transaksi as TransaksiModel;
use App\Models\TransaksiDetail as TransaksiDetailModel;
use App\Services\Transaksi\Models\Transaksi as TransaksiServiceModel;
use App\Services\Transaksi\Models\TransaksiDetail as TransaksiDetailServiceModel;

class Repository implements Transaksi
{
    public function insertTransaction(TransaksiServiceModel $transactionData) : TransaksiServiceModel|bool
    {
        $transactionNumberField = TransaksiModel::TRANSACTION_NUMBER_FIELD;
        $totalField = TransaksiModel::TOTAL_FIELD;
        $transactionDateField = TransaksiModel::TRANSACTION_DATE_FIELD;
        $customerNameField = TransaksiModel::CUSTOMER_NAME_FIELD;
        $userIDField = TransaksiModel::USER_ID_FIELD;

        $transaction = new TransaksiModel();

        $transaction->$transactionNumberField = $transactionData->transaction_number;
        $transaction->$totalField = $transactionData->total;
        $transaction->$transactionDateField = $transactionData->transaction_date;
        $transaction->$customerNameField = $transactionData->customer_name;
        $transaction->$userIDField = $transactionData->user_id;

        $isSuccess = $transaction->save();
        if(!$isSuccess) {
            return false;
        }

        $transactionData->id = $transaction->getIdAttribute();

        return $transactionData;
    }

    public function deleteTransactionByID(string $id): bool
    {
        $deletedTransaction = TransaksiModel::destroy($id);

        return $deletedTransaction > 0;
    }

    public function insertTransactionDetails(TransaksiDetailServiceModel $transaksiDetailData): TransaksiDetailServiceModel|bool
    {
        $quantityField = TransaksiDetailModel::TRANSACTION_DETAIL_QUANTITY_FIELD;
        $totalField = TransaksiDetailModel::TRANSACTION_DETAIL_TOTAL_FIELD;
        $vehicleID = TransaksiDetailModel::TRANSACTION_DETAIL_VEHICLE_ID_FIELD;
        $transactionID = TransaksiDetailModel::TRANSACTION_ID_FIELD;

        $transactionDetail = new TransaksiDetailModel();

        $transactionDetail->$quantityField = $transaksiDetailData->quantity;
        $transactionDetail->$totalField = $transaksiDetailData->total;
        $transactionDetail->$vehicleID = $transaksiDetailData->vehicle_id;
        $transactionDetail->$transactionID = $transaksiDetailData->transaction_id;

        $isSuccess = $transactionDetail->save();
        if(!$isSuccess) {
            return false;
        }

        $transaksiDetailData->id = $transactionDetail->getIdAttribute();

        return $transaksiDetailData;
    }

    /**
     * @param string[] $id
    **/
    public function deleteTransactionDetailByIDs(array $id): bool
    {
        $deletedTransaction = TransaksiDetailModel::destroy($id);

        return $deletedTransaction > 0;
    }

    public function getTransaction(string $customerName, string $userID): array
    {
        $data = TransaksiModel::all();

        if ($customerName != '') {
            $data = $data->where(TransaksiModel::CUSTOMER_NAME_FIELD, $customerName);
        }

        if ($userID != '') {
            $data = $data->where(TransaksiModel::USER_ID_FIELD, $userID);
        }

        $results = [];

        $transactionNumberField = TransaksiModel::TRANSACTION_NUMBER_FIELD;
        $totalField = TransaksiModel::TOTAL_FIELD;
        $transactionDateField = TransaksiModel::TRANSACTION_DATE_FIELD;
        $customerNameField = TransaksiModel::CUSTOMER_NAME_FIELD;
        $userIDField = TransaksiModel::USER_ID_FIELD;

        foreach ($data as $datum) {
            $results[] = new TransaksiServiceModel($datum->$transactionNumberField, $datum->$transactionDateField, $datum->$totalField, $datum->$customerNameField, $datum->$userIDField, $datum->getIdAttribute());
        }

        return $results;
    }
}
