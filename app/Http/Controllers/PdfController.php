<?php

namespace App\Http\Controllers;

use Exception;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;

// private $nome;

class PdfController extends Controller
{

    protected $nome;
    protected $email;
    public function __construct($nome, $email)
    {
        $this->nome = $nome;
        $this->email = $email;
    }


    public function generate($signature = null, $show = false, $nome_certificado = null)
    {
        try {

            define('FPDF_FONTPATH', getcwd() . '/fonts/');
            $certificado = getcwd() . '/pdf/certificadoADF.pdf';
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->AddFont('OpenSans-Extrabold', '', 'opensans-extrabold.php');
            $pdf->setSourceFile($certificado);
            $tplIdx = $pdf->importPage(1);
            $pdf->setFont('OpenSans-Extrabold');
            $pdf->SetFontSize(50);
            $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
            // calculate x and y coordinates for text cell
            $pdf->SetY(115);
            // create a cell and position it in the center of the page
            $pdf->Cell(0, 0, mb_convert_encoding($this->nome, 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');

            $pdf->SetFontSize(18);
            $pular = 140;
            $pdf->SetXY(30,$pular);
            $pdf->MultiCell(0, 10,  mb_convert_encoding(env('TEXTO_DARTWEEK'), 'ISO-8859-1', 'UTF-8'), 0, 'J');
            $pular += 10;
            $pdf->SetXY(30,$pular);
            $pdf->MultiCell(0, 10,  mb_convert_encoding(env('TEXTO_DARTWEEK2'), 'ISO-8859-1', 'UTF-8'),0,'J');





            // $pdf->Cell(0, 0, mb_convert_encoding($this->nome,'ISO-8859-2','UTF-8'), 0, 0, 'C');
            $resultado =  $pdf->Output('S');
            $uuid = (string) Str::uuid();
            $generate = '/tmp/' . $uuid . '.pdf';
            unset($pdf);
            file_put_contents($generate, $resultado);

            if ($signature != null) {
                $token = $signature;
            } else {
                $token = (hash_file('sha1', ($generate)));
            }
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->AddFont('OpenSans-Extrabold', '', 'opensans-extrabold.php');
            $pdf->setSourceFile($generate);
            $tplIdx = $pdf->importPage(1);
            $pdf->setFont('OpenSans-Extrabold');
            $pdf->SetFontSize(50);
            $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
            $pdf->SetY(130);
            $pdf->SetFontSize(6);
            // create a cell and position it in the center of the page
            $pdf->Cell(0, 0, $token, 0, 0, 'C');
            if ($show == true) {
                $certificado = 'certificado.pdf';
                if ($nome_certificado != null) {
                    $certificado = $nome_certificado . '.pdf';
                }
                return $pdf->OutPut('I', $certificado);
            }
            // @unlink($generate);
            return [
                // 'output' => base64_encode($pdf->Output('S')),
                'signature' => $token
            ];
        } catch (Exception $e) {
            dd($e);
        }
    }
}
