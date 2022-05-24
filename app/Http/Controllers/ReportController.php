<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Dompdf\Dompdf;
use PDF;

class ReportController extends Controller
{
    public function index()
	{
    }

    public function spjpk()
	{
        $data=[];
        $pdf = PDF::loadView('cetakan.spjpk', $data)->setPaper('a4', 'portrait');;
        return $pdf->download('spjpk.pdf');
    }
    
    public function suratLembur()
	{
        $data=[];
        $pdf = PDF::loadView('cetakan.surat-lembur', $data)->setPaper('a5', 'landscape');;
        return $pdf->download('surat-lembur.pdf');
    }

    public function suratCuti()
	{
        $data=[];
        $pdf = PDF::loadView('cetakan.surat-cuti', $data)->setPaper('a5', 'landscape');;
        return $pdf->download('surat-cuti.pdf');
    }
}
