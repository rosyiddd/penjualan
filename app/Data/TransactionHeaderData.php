<?php

namespace App\Data;

use Illuminate\Support\Facades\Date;

class TransactionHeaderData {
    public String $documentCode;
    public String $documentNumber;
    public String $user;
    public int $total;
    public Date $date;
}
