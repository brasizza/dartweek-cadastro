<?php

namespace App\Console\Commands;

use App\Http\Controllers\PdfController;
use Illuminate\Console\Command;
use setasign\Fpdi\Fpdi;

class generatePDF extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generatePDF';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        define('FPDF_FONTPATH', getcwd() . '/public/fonts');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $pdf = new PdfController('Marcus Vinícius Brasizza', 'oioi@oi.com.br');

        $pdf->generate(null, true);
        // $certificado = getcwd() . '/public/pdf/certificadoADF.pdf';
        // $pdf = new Fpdi();
        // $pdf->AddPage();
        // $pdf->AddFont('OpenSans-Extrabold');
        // $pdf->setSourceFile($certificado);

        // $tplIdx = $pdf->importPage(1);
        // $specs = $pdf->getTemplateSize($tplIdx);
        // $pdf->setFont('OpenSans-Extrabold');
        // $pdf->SetFontSize(50);

        // $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
        // // $pdf->SetXY(180,  140);

        // $pageWidth = $pdf->getPageWidth();
        // $pageHeight = $pdf->getPageHeight();
        // // calculate x and y coordinates for text cell
        // $pdf->SetY(100);


        // // create a cell and position it in the center of the page
        // $pdf->Cell(0, 0, mb_convert_encoding('Marcus Vinicius Brasizza', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');

        // $pdf->SetFontSize(10);
        // $pdf->SetY(150);

        // $pdf->Cell(0, 0, "Token: 329023uf0923j9f023jf092jf09", 0, 0, 'C');



        // $pdf->Output('F', '/tmp/aluno.pdf');
    }
}
