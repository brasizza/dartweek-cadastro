<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CertificadoController extends Controller
{

    use ApiResponser;

    private function adicionarCertificado($nome,$email,$signature){


        $certificado = Certificado::where('signature', $signature)->first();

        if(!$certificado){
            Certificado::create([
                'name' => $nome,
                'email' =>$email,
                'signature' => $signature
            ]);
        }

    }
    public function enviar(Request $request){

        $data = $request->all();

      try{

        $pdf = new PdfController($request->nome, $request->email);
        $generated = $pdf->generate();
        $this->adicionarCertificado($request->nome,$request->email,$generated['signature']);
        Mail::send('emails.certificado', $data, function($message)use($data, $generated) {
            $message->to($data["email"], $data["email"])
                    ->subject('SEU CERTIFICADO')
                    ->attachData(base64_decode($generated['output']), "certificado.pdf");

        });
        return  $this->successResponse('EMAIL ENVIADO COM SUCESSO!');

      }catch(Exception $e){
        Log::debug(print_r($e,true));
        return  $this->errorResponse('FALHA AO ENVIAR EMAIL' . print_r($e,true), 500);
      }

    }
}
