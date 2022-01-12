<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmOrder extends Model
{
    public $table = 'confirmorders';
    protected $fillable = [
        'orderid', 'invoiceno', 'gtotal', 'invoicedate', 'status', 'paymethod', 'txnid', 'cid'
    ];
}
