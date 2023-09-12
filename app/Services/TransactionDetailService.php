<?php

namespace App\Services;

use App\Data\TransactionDetailData;
use App\Models\TransactionDetail;

class TransactionDetailService {

    public function add(TransactionDetailData $data):TransactionDetail
    {
        $transactionDetail = new TransactionDetail();
        $transactionDetail->document_code= $data->documentCode;
        $transactionDetail->document_number= $data->documentNumber;
        $transactionDetail->product_code = $data->productCode;
        $transactionDetail->price = $data->price;
        $transactionDetail->quantity = $data->quantity;
        $transactionDetail->unit = $data->unit;
        $transactionDetail->sub_total = $data->subTotal;
        $transactionDetail->currency = $data->currency;
        $transactionDetail->save();

        return $transactionDetail;
    }
    public function findById($documentCode)
    {
        return TransactionDetail::where('document_code', $documentCode)->get();
    }
}