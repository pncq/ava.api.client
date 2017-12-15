<?php

// Especificar endereço base e versão da api
$baseurl = '<<server>>/api';
$apiversion = '/v2';

/**
  * Autenticar e obter o token
  */
$curl = curl_init($baseurl . $apiversion . "/oauth2/token");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Especificar os argumentos obrigatórios a serem passados para o servidor
$data = array(
    "grant_type" => "password",
    "username" => "<<username>>",
    "password" => "<<password>>"
);

curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded')); 

// Fazer a chamada REST e obter o resultado
$response = curl_exec($curl);
if (!$response) {
    die("Falha na conexão.\n");
}

// Converter o resultado do formato JSON para um array PHP
$result = json_decode($response);

curl_close($curl);

// Verificando possível erro
if ( isset($result->error) ) {
    die($result->error."\n");
}

$token = $result->access_token;

echo "Successo! OAuth token: $token\n";

$curl = curl_init($baseurl . $apiversion . "/CircularMaterial/1");
curl_setopt($curl, CURLOPT_POST, false);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json',"Authorization: Bearer $token")); 

// Fazer a chamada REST e obter o resultado
$response = curl_exec($curl);
if (!$response) {
    die("Falha na conexão.\n");
}

// Converter o resultado do formato JSON para um array PHP
$result = json_decode($response);

curl_close($curl);

// Verificando possível erro
if ( isset($result->error) ) {
    die($result->error."\n");
}

var_dump($result);

?>
