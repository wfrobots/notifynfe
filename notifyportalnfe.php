<?php
$url = 'http://www.nfe.fazenda.gov.br/portal/principal.aspx';
$link = 'http://www.nfe.fazenda.gov.br/portal/';

function quebra($texto, $inicio, $final) {
    $quebrado = explode($inicio, $texto);
    @$quebrado = explode($final, $quebrado[1]);
    $quebrado = $quebrado[0];
    return $quebrado;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HEADER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_REFERER => $url,
  
));

$response = curl_exec($curl);
$response = utf8_encode($response);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  //echo $response;
  }
  
  
  
 $aviso = quebra($response,'</style>','<p id="demo"></p>');
 
 
 
$head = quebra($response,'<html xmlns="http://www.w3.org/1999/xhtml">','<body onselectstart');
 
$head = str_replace('src="', 'src="'.$link.'/', $head);
$head = str_replace('href="', 'href="'.$link.'/', $head);

$response = explode('divInformes',$response);
//echo $response;
$msg =  $response[1];
$msg = str_replace('href="', 'href="'.$link.'/', $msg);
$msg = quebra($msg,'divHlkInformes',' <div id="divDenegacao">');
$msg = quebra($msg,'<p>','</br>');



// O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
// O return-path deve ser ser o mesmo e-mail do remetente.
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8\r\n";
$headers .= "From: notify@mail.com.br\r\n"; // remetente
$headers .= "Return-Path: notify@mail.com.br\r\n"; // return-path
$envio = mail("wellingtonfonseca@cw2gisoedagen.com.br", "Informe Receita", $head.$aviso.$msg, $headers);
 
if($envio)
 echo "Mensagem enviada com sucesso";
else
 echo "A mensagem não pode ser enviada";


?>
