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

    private function existeCertificadoEmail($email){

        return Certificado::where('email', $email)->first();

    }


    public function findByEmail(Request $request){

        $email = $request->email;
        $certificado =  Certificado::where('email', $email)->first();
            if($certificado){

                $signature = $certificado['signature'];
            $pdf = new PdfController($certificado['name'], $certificado['email']);
            return  $pdf->generate($signature,true);
        }
        else{
            return redirect('/');
        }


    }

    public function resendEmail(Request $request){
        $certificado =  Certificado::where('email', $request->email)->first();
        if($certificado){
            $envio = new Request($certificado->toArray());
             $this->enviar($envio);
            return view('emails.certificado');

        }
    }

    public function findBySignature(Request $request){

        $signature = $request->verify;

        $certificado =  Certificado::where('signature', $signature)->first();

            if($certificado){

                $signature = $certificado['signature'];
            $pdf = new PdfController($certificado['name'], $certificado['email']);
            return  $pdf->generate($signature,true);
        }
        else{
            return redirect('/');
        }


    }

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
        $certificado = $this->existeCertificadoEmail($request->email);

        // dd($certificado);
        if($certificado){

            $signature = $certificado['signature'];
        }else{
            $signature = null;
        }


        $pdf = new PdfController($request->nome, $request->email);
        $generated = $pdf->generate($signature);

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
