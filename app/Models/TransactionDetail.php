<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = "transaction_detail";

    public $timestamps = [];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
