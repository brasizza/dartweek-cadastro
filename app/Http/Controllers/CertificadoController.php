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

    private function existeCertificadoEmail($email)
    {

        return Certificado::where('email', $email)->first();
    }

    public function existeCertificadoSignature($signature)
    {

        return Certificado::where('signature', $signature)->first();
    }


    public function findByEmail(Request $request)
    {

        $email = $request->email;
        $certificado =  Certificado::where('email', $email)->first();
        if ($certificado) {

            $signature = $certificado['signature'];
            $pdf = new PdfController($certificado['name'], $certificado['email']);
            return  $pdf->generate($signature, true);
        } else {
            return redirect('/');
        }
    }

    public function resendEmail(Request $request)
    {
        $certificado =  Certificado::where('email', $request->email)->first();
        if ($certificado) {

            $envio = new Request($certificado->toArray());
            $this->enviar($envio);
            return view('emails.certificado');
        }
    }

    public function findBySignature(Request $request)
    {

        $signature = $request->verify;

        $certificado =  Certificado::where('signature', $signature)->first();

        if ($certificado) {
            $signature = $certificado['signature'];
            $pdf = new PdfController($certificado['name'], $certificado['email']);
            return  $pdf->generate($signature, true, 'certificado_' . $signature);
        } else {
            return redirect('/');
        }
    }

    private function adicionarCertificado($nome, $email, $signature)
    {

        $certificado = Certificado::where('signature', $signature)->first();

        if (!$certificado) {
            Certificado::create([
                'name' => $nome,
                'email' => $email,
                'signature' => $signature
            ]);
        }
    }


    public function downloadCertificado(Request $request)
    {

        $requestSignature = new Request(['verify' => base64_decode($request->verify ?? '')]);

        return $this->findBySignature($requestSignature);
    }

    // public function gerar(Request $request){

    //     try{
    //     $pdf = new PdfController($request->name ?? $request->nome, $request->email);
    //     $generated = $pdf->generate(null);

    //     return 'OK';
    //     }catch(Exception $e){

    //         return 'ERRO';
    //     }

    // }

    public function gerar(Request $request)
    {

        $data = $request->all();

        try {
            $certificado = $this->existeCertificadoEmail($request->email);

            if ($certificado) {

                $signature = $certificado['signature'];
            } else {
                $signature =   password_hash( implode('', $request->all()), CRYPT_BLOWFISH);
            }

            $generated['signature'] = $signature;
            $this->adicionarCertificado($request->nome, $request->email, $generated['signature']);

            $generated['signature'] = base64_encode($signature);
            return  $this->successResponse($generated);
        } catch (Exception $e) {



            // Log::debug(print_r($e,true));
            return  $this->errorResponse('FALHA -' . $e->getMessage(), 500);
        }
    }
}
