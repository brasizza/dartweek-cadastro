<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConclusaoController extends Controller
{


    public function concluirCertificado(Request $request){

        if($request->has('verify')){

            $certificado = new CertificadoController();
            $existe = $certificado->existeCertificadoSignature(base64_decode($request->verify));

            if($existe){
                return view('concluido.index')->with(['signature' => $request->verify]);

            }else{
                return redirect('/');

            }
        }else{

        }
    }
    public function index()
    {



        $aulas = [
            [

                'imagem' => '/images/senha1.png',
                'titulo' => 'Senha da aula 1'

            ],

            [

                'imagem' => '/images/senha2.png',
                'titulo' => 'Senha da aula 2'

            ],
            [

                'imagem' => '/images/senha3.png',
                'titulo' => 'Senha da aula 3'

            ],

            [

                'imagem' => '/images/senha4.png',
                'titulo' => 'Senha da Live de encerramento'

            ],

        ];



        return view('landpage.index')->with(['aulas' => $aulas]);
    }


    public function frase()
    {





        return view('landpage.frase');
    }
}
