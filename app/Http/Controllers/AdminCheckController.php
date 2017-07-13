<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Model\Client;

require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
require_once base_path('vendor/tecnickcom/tcpdf/config/tcpdf_config.php');

class AdminCheckController extends Controller
{
    public function index()
    {
        return view('admin.check.index');
    }

    public function package(Request $request)
    {
        $contractnos = $request->input('contractnos');
        $clients = Client::whereIn('contractno', $contractnos)->get();

        foreach ($clients as $client) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetTitle('TCPDF Example 006');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);

            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            if (@file_exists(base_path('vendor/tecnickcom/tcpdf/examples/lang/eng.php'))){
                require_once(base_path('vendor/tecnickcom/tcpdf/examples/lang/eng.php'));
                $pdf->setLanguageArray($l);
            }
            $pdf->SetFont('droidsansfallback', '', 10);
            $pdf->AddPage();

            $html = view('admin.check.template', ['client' => $client])->__toString();

            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('example_006.pdf', 'I');
        }
    }
}
