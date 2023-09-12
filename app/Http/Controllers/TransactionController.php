<?php

namespace App\Http\Controllers;

use App\Data\TransactionDetailData;
use App\Data\TransactionHeaderData;
use App\Helper\PDF;
use App\Helper\PDFHelper;
use App\Services\ProductService;
use App\Services\TransactionDetailService;
use App\Services\TransactionHeaderService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionHeaderService $transactionHeaderService;
    private TransactionDetailService $transactionDetailService;

    private ProductService $productService;

    public function __construct(){
        $this->transactionHeaderService = new TransactionHeaderService;
        $this->transactionDetailService = new TransactionDetailService;
        $this->productService = new ProductService;
    }

    public function createTransactionHeader(){
        $transactionHeaderData = new TransactionHeaderData();
        $transactionHeaderData->total = request('total');
        $transactionHeaderData->user = request()->session()->get('user');

        $transactionHeader = $this->transactionHeaderService->add($transactionHeaderData);
        foreach(request('data') as $data){
            $this->createTransactionDetail(
                $transactionHeader->document_code,
                $transactionHeader->document_number,
                $data);
        }
    }

    private function createTransactionDetail(String $documentCode, String $documentNumber, $data){
        $transactionDetailData = new TransactionDetailData();
        $transactionDetailData->documentCode = $documentCode;
        $transactionDetailData->documentNumber = $documentNumber;
        $transactionDetailData->productCode = $data['product_code'];
        $transactionDetailData->price = $data['price'];
        $transactionDetailData->quantity = $data['quantity'];
        $transactionDetailData->subTotal = $data['quantity'] * $data['price'];
        $transactionDetailData->unit = $data['unit'];
        $transactionDetailData->currency = $data['currency'];
        $this->transactionDetailService->add($transactionDetailData);
    }
    public function print() {
        $transactionHeaders = $this->transactionHeaderService->all();
        $temp = "";
        foreach($transactionHeaders as $transactionHeader){
            $trxDetail = $this->transactionDetailService->findById($transactionHeader->document_code);
            foreach($trxDetail as $trx){
                $product = $this->productService->get($trx->product_code);
                $temp .= "{$product->product_name} x {$trx->quantity}\n";
                $transactionHeader->trxDetail = $temp;
            }
        }
        $pdf = new PDFHelper;
        $pdf->index($transactionHeaders);
    }
}
