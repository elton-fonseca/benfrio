<?php

namespace App\Http\Controllers;

use App\Repositories\NfeRepository;
use App\helpers\Gerais;
use Illuminate\Http\Request;

class NfeController extends Controller
{
    private $nfe;

    public function __construct()
    {
        $this->nfe = new NfeRepository();
    }


    public function mostrarIndex()
    {
        $NFEs = $this->nfe->trazerNfe();

        return \View::make('nfe.listar', array('NFEs' => $NFEs));
    }

    public function mostrarBusca(Request $request)
    {
        $NFEs = $this->nfe->trazerNfeBusca($request->only('busca'));

        return \View::make('nfe.listar', array('NFEs' => $NFEs));
    }

    public function baixarXml($nota, $ano, $mes)
    {
        downloadXml($nota, $ano, $mes);

        //Código usado para google cloud platform
        // $nota = substr($nota, 1, 5);

        // $pastaAno = getFolderPath($ano);
        // $pastaMes = getFolderPath($ano . $mes, $pastaAno);

        // return getFileFromPath($nota, 'xml', $pastaMes, 38, 5);

    }

    public function baixarPdf($nota, $ano, $mes)
    {
        downloadPdfNota($nota, $ano, $mes);

        //Código usado para google cloud platform
        // $nota = substr($nota, 1, 5);

        // $pastaAno = getFolderPath($ano);
        // $pastaMes = getFolderPath($ano . $mes, $pastaAno);
        // $pastaMes = getFolderPath('PDF', $pastaMes);

        // return getFileFromPath($nota, 'pdf', $pastaMes, 2, 5);
    }
}
