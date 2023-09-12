<?php

namespace App\Helper;

use Codedge\Fpdf\Fpdf\Fpdf;

class PDFHelper{
    protected $fpdf;
 
    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    public function index($transactions)
    {
        $this->fpdf->AddPage();
        $this->fpdf->SetFont('Times','B',13);
        $this->fpdf->Cell(200,10,'Report Penjualan',0,0,'C');
        
        $this->fpdf->Cell(10,15,'',0,1);
        $this->fpdf->SetFont('Times','B',9);
        $this->fpdf->Cell(10,7,'No',1,0,'C');
        $this->fpdf->Cell(40,7,'Transaction',1,0,'C');
        $this->fpdf->Cell(20,7,'User',1,0,'C');
        $this->fpdf->Cell(20,7,'Total' ,1,0,'C');
        $this->fpdf->Cell(20,7,'Date',1,0,'C');
        $this->fpdf->Cell(60,7,'Item',1,0,'C');

        
        $this->fpdf->Cell(10,7,'',0,1);
        $this->fpdf->SetFont('Times','B',10);
        
        $no=1;
        foreach($transactions as $trx){
            $this->fpdf->Cell(10,6, $no++,1,0,'C');
            $this->fpdf->Cell(40,6, $trx->document_code,1,0);
            $this->fpdf->Cell(20,6, $trx->user,1,0);
            $this->fpdf->Cell(20,6, $trx->total,1,0);
            $this->fpdf->Cell(20,6, date_format($trx->date,'Y/m/d'),1,0);
            // foreach($trx->trxDetail as $item){
                $this->fpdf->Cell(60,6, $trx->trxDetail,1,1);
            // }
        }
        $this->fpdf->Output();

        exit;
    }
}
