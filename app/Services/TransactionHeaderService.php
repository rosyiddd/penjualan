<?php

namespace App\Services;

use App\Data\TransactionHeaderData;
use App\Models\TransactionHeader;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class TransactionHeaderService {

    public function add(TransactionHeaderData $data):TransactionHeader
    {
        $transactionHeader = new TransactionHeader();
        $transactionHeader->document_code = Str::random(3);
        $transactionHeader->document_number = Str::random(9);
        $transactionHeader->user = $data->user;
        $transactionHeader->total = $data->total;
        $transactionHeader->save();
        return $transactionHeader;
    }
    public function all(){
        return TransactionHeader::all();
    }
}