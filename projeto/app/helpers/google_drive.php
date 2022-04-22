<?php
/* 
function getFolderPath($name, $base='/')
{
    $folders = collect(\Storage::cloud()->listContents($base, false));

    $dir = $folders->where('type', '=', 'dir')
                  ->where('filename', '=', $name)
                  ->first();

    return $dir['path'];
}

function getFileFromPath($seachID, $extension, $path='/', $searchIni, $searchQtd)
{
    $contents = collect(Storage::cloud()->listContents($path, false));

    $file = $contents->where('type', '=', 'file')
                    ->where('extension', '=', $extension)
                    ->filter(function ($file, $key) use ($seachID, $searchIni, $searchQtd) {
                        return substr($file['filename'], $searchIni, $searchQtd) == $seachID;
                    })->first();

    if (!$file) {
        return back()->with(['mensagem' => 'Esse arquivo não está disponível para download']);
    }
    
    $rawData = Storage::cloud()->get($file['path']);
                    
    return response($rawData, 200)
              ->header('ContentType', $file['mimetype'])
              ->header('Content-Disposition', "attachment; filename='" . $file['filename'] . "." . $extension . "'");
}
 */