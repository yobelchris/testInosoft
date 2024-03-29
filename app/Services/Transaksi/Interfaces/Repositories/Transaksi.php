<?php
declare(strict_types=1);

namespace App\Services\Transaksi\Interfaces\Repositories;

use App\Services\Transaksi\Models\Transaksi as TransaksiServiceModel;
use App\Services\Transaksi\Models\TransaksiDetail as TransaksiDetailServiceModel;

interface Transaksi
{
    public function insertTransaction(TransaksiServiceModel $transactionData) : TransaksiServiceModel|bool;
    public function deleteTransactionByID(string $id) : bool;
    public function insertTransactionDetails(TransaksiDetailServiceModel $transaksiDetailData) : TransaksiDetailServiceModel|bool;
    public function deleteTransactionDetailByIDs(array $id) : bool;

    /**
     * @return TransaksiServiceModel[]
     **/
    public function getTransaction(string $customerName, string $userID, string $transactionNumber, string $transactionID): array;

    /**
     * @return TransaksiDetailServiceModel[]
    **/
    public function getTransactionDetail(string $transactionID, string $vehicleID) : array;
}
