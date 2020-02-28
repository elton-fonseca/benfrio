<?php

namespace App\Http\Controllers;

use App\Repositories\CameraRepository;

class CameraController extends Controller
{
    private $camera;

    public function __construct()
    {
        $this->camera = new CameraRepository();
    }

    //Exibe a quantidade de posições vazias
    public function mostrarIndex()
    {
        return \View::make(
            'camera.posicao',
        [
        'posicao' => $this->camera->posicaoVazia()
        ]
        );
    }
}
