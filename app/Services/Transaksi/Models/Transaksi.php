<?php
declare(strict_types=1);

namespace App\Services\Transaksi\Models;

class Transaksi
{
    public string $id;
    public string $transaction_number;
    public \DateTime $transaction_date;
    public float $total;
    public string $customer_name;
    public string $user_id;

    /** @var TransaksiDetail[] **/
    public array $transaksiDetail;

    public function __construct(string $transactionNumber, \DateTime $transactionDate, float $total, string $customerName, string $userId, string $id = '') {
        $this->transaction_number = $transactionNumber;
        $this->transaction_date = $transactionDate;
        $this->total = $total;
        $this->customer_name = $customerName;
        $this->user_id = $userId;
        $this->id = $id;
    }
}
