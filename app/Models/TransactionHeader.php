<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;
    
    protected $table = "transaction_header";

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;
    const CREATED_AT = 'date';
}
