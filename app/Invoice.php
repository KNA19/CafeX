<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $table = 'invoices';
    protected $fillable = [
        'id', 'invoiceno', 'itemname', 'unitprice', 'itemid', 'qty', 'total'
    ];
}
