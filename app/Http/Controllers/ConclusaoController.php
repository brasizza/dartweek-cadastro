<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConclusaoController extends Controller
{


    public function teste(){

        $enviar = new CertificadoController();
        $request = new Request([

            'nome' => 'Marcus Brasizza' ,
            'email' => 'mvbdesenvolvimento@gmail.com'
        ]);
        $enviar->enviar($request);

        return view('emails.certificado');
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
                'titulo' => 'Senha da aula 4'

            ],
            [

                'imagem' => '/images/senha5.png',
                'titulo' => 'Senha da aula 5'

            ],
            [

                'imagem' => '/images/senha6.png',
                'titulo' => 'Senha da Live de encerramento'

            ],

        ];



        return view('concluido.index')->with(['aulas' => $aulas]);
    }
}
