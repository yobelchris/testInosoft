<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
class Transaksi extends Model
{
    use HasFactory;

    protected $collection = 'transaksi';

    const TRANSACTION_NUMBER_FIELD = 'transaction_number';
    const TOTAL_FIELD = 'total';
    const TRANSACTION_DATE_FIELD = 'transaction_date';
    const CUSTOMER_NAME_FIELD = 'customer_name';
    const USER_ID_FIELD = 'user_id';

    protected $dates = [self::TRANSACTION_DATE_FIELD];
}
