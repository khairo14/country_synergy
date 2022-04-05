<?php

namespace App\Http\Controllers;
use PDF;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function palletlabels() {
       return view('pallet_labels');
    }

    public function printlabels() {
        $data = [
            'title' => 'Country Synergy',
            'date' => date('m/d/Y')
        ];
        
        $customPaper = array(0,0,289.13,425.19);
        $pdf = PDF::loadView('printlabels', $data)->setPaper($customPaper, 'portrait');;
     
        return $pdf->download('PalletLabels.pdf');
    }
}
