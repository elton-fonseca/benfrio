<?php

namespace App\Repositories;

class CameraRepository
{
    public function posicaoVazia()
    {
        //echo 'teste';
        $dados = \DB::table('cadcam')
                    ->select(\DB::raw('sum(QTD1_CAM) as QTD'))
                    ->where('QTD1_CAM', '>', 0)
                    ->first();

        return (int) $dados->QTD;
    }
}
