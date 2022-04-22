<?php 

//use Knp\Snappy\Pdf;
use Symfony\Component\Finder\Finder;

//Converte data para formato Mysql
  function brToMysql($data)
  {
      return implode("-", array_reverse(explode("/", $data)));
  }

  //Converte data para formato BR
  function mysqlToBr($data)
  {
      return implode("/", array_reverse(explode("-", $data)));
  }

  //Formata hora para formato HH:MM
  function formataHora($hora)
  {
      return $hora[0] . $hora[1] . ':' . $hora[2] . $hora[3];
  }

  //Formata hora para formato HHMM do banco de dados
  function formataHoraBanco($hora)
  {
      if (strlen($hora) == 4) {
          return "0" . $hora[0] . $hora[2] . $hora[3];
      }

      return $hora[0] . $hora[1] .  $hora[3] . $hora[4];
  }

  //Insere mascara nos campos pallets
  function formataPallet($value = "")
  {
      $p1 = substr($value, 0, 6);
      $p2 = substr($value, 6, 2);
      $p3 = substr($value, 8, 2);

      return $p1 . '.' . $p2 . '.' . $p3;
  }

  //Usar nas buscas por numpalett
  function limpaPallet($value="")
  {
      return str_replace('.', '', $value);
  }

  function posicao($posicao)
  {
    if ($posicao == "primeiro") {
        return "1° a carregar";
    }

    if ($posicao == "segundo") {
        return "2° a carregar";
    }

    if ($posicao == "terceiro") {
        return "3° a carregar";
    }

    if ($posicao == "quarto") {
        return "4° a carregar";
    }

    if ($posicao == "quinto") {
        return "5° a carregar";
    }

    if ($posicao == "sexto") {
        return "6° a carregar";
    }

    return $posicao;
  }

  //Formata hora para formato HH:MM
  function gerarPDF($html, $horientacao="retrato")
  {
      $html = utf8_encode($html);
      $mpdf = new \Mpdf\Mpdf();
      $mpdf->WriteHTML($html);
      $mpdf->Output("relatorio_". date('m-d-Y_h-i') .".pdf", 'D');
      
      exit();
  }

  //Download do xls
  function gerarXls($conteudo)
  {
      $arquivo = "relatorio_". date('m-d-Y_h-i') .".xls";

      // informa o tipo do arquivo ao navegador
      header("Content-Type: application/vnd.ms-excel");

      // informa ao navegador que o arquivo deve ser aberto para download
      // informa ao navegador o nome do arquivo
      header("Content-Disposition: attachment; filename=".basename($arquivo));

      echo $conteudo; // lê o arquivo

      exit;
  }

    //Download do xls
  function gerarTxt($conteudo)
  {
      $arquivo = "relatorio_". date('m-d-Y_h-i') .".txt";

      // informa o tipo do arquivo ao navegador
      header("Content-Type: text/plain");

      // informa ao navegador que o arquivo deve ser aberto para download
      // informa ao navegador o nome do arquivo
      header("Content-Disposition: attachment; filename=".basename($arquivo));

      echo $conteudo; // lê o arquivo

      exit;
  }

  //Formata hora para formato brasileiro
  function formataNumero($numero)
  {
      return number_format($numero, 2, ",", ".");
  }

  //Download do XML a partir do número da nota
  function downloadPdfNota($nota, $ano, $mes)
  {
      //Remove o N do numero da nota
      //$nota = substr($nota, 1, 5);

      //Instancia a classe do componente
      $finder = new Finder();

      //Como deve ser o nome do arquivo
      $finder->name("?{$nota}.pdf");

      //Passa o nome do arquivo para a variável
      foreach ($finder->in("/home/benfrio/ftp/{$ano}/{$ano}{$mes}/PDF") as $file) {
          $arquivo = $file->getRealpath();
      }
      //echo $arquivo;
      // informa o tipo do arquivo ao navegador
      header("Content-Type: application/save");

      // informa o tamanho do arquivo ao navegador
      header("Content-Length: ".filesize($arquivo));

      // informa ao navegador que o arquivo deve ser aberto para download
      // informa ao navegador o nome do arquivo
      header("Content-Disposition: attachment; filename=".basename($arquivo));

      readfile($arquivo); // lê o arquivo

      exit;
  }

  //Download do XML a partir do número da nota
  function downloadXml($nota, $ano, $mes)
  {
      //Remove o N do numero da nota
      $nota = substr($nota, 1, 5);

      //Instancia a classe do componente
      $finder = new Finder();

      //Como deve ser o nome do arquivo
      $finder->name("??????????????????????????????????????{$nota}?-nfe.xml");

      //Passa o nome do arquivo para a variável
      foreach ($finder->in("/home/benfrio/ftp/{$ano}/{$ano}{$mes}") as $file) {
          $arquivo = $file->getRealpath();
      }
      //echo $arquivo;
      // informa o tipo do arquivo ao navegador
      header("Content-Type: application/save");

      // informa o tamanho do arquivo ao navegador
      header("Content-Length: ".filesize($arquivo));

      // informa ao navegador que o arquivo deve ser aberto para download
      // informa ao navegador o nome do arquivo
      header("Content-Disposition: attachment; filename=".basename($arquivo));

      readfile($arquivo); // lê o arquivo

      exit;
  }





  //Verifica se existe o arquivo XML
  function existeXml($nota, $ano, $mes)
  {
    //Remove o N do numero da nota
      $nota = substr($nota, 1, 5);

      //Instancia a classe do componente
      $finder = new Finder();

      //Como deve ser o nome do arquivo
      $finder->name("??????????????????????????????????????{$nota}?-nfe.xml");

      //Passa o nome do arquivo para a variável
      foreach ($finder->in("/home/benfrio/ftp/{$ano}/{$ano}{$mes}") as $file) {
          $arquivo = $file->getRealpath();
      }

      return (isset($arquivo)) ? true : false;
  }

  //Verifica se existe o arquivo PDF
  function existePdf($nota, $ano, $mes)
  {
        //Instancia a classe do componente
        $finder = new Finder();

        //Como deve ser o nome do arquivo
        $finder->name("?{$nota}.pdf");
    
        //Passa o nome do arquivo para a variável
        foreach ($finder->in("/home/benfrio/ftp/{$ano}/{$ano}{$mes}/PDF") as $file) {
            $arquivo = $file->getRealpath();
        }
    
        return (isset($arquivo)) ? true : false;
  }

  //Verifica se existe o arquivo PDF
  function removeSerieDoPallet($pallet)
  {
      return substr($pallet, 0, 8);
  }

  