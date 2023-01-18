<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConclusaoController extends Controller
{
    public function index()
    {



        $aulas = [
            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 1 - BLA BLA'

            ],

            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 2 - BLA BLA'

            ],
            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 3 - BLA BLA'

            ],
            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 4 - BLA BLA'

            ],
            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 5 - BLA BLA'

            ],
            [

                'imagem' => 'https://picsum.photos/seed/' . rand(1,4000) . '/200/300',
                'titulo' => 'Aula 6 - BLA BLA'

            ],

        ];



        return view('concluido.index')->with(['aulas' => $aulas]);
    }
}
