<?php

function varDump($data){
   echo '<pre>' . var_export($data, true) . '</pre>'; 
}
function api_post($url, $data)
{
  $curl = curl_init($url);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl,CURLOPT_HTTPHEADER,
    array(
      'Content-Type: multipart/form-data',
      'x-api-key: apikey123'
    )
  );

  $response = array(
    "data" => json_decode(curl_exec($curl), TRUE),
    "status" => curl_getinfo($curl, CURLINFO_HTTP_CODE),
  );

  curl_close($curl);
  return $response;
}

function api_post_id($url, $id)
{
  $curl = curl_init($url . $id);

  $CI = get_instance();

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt(
    $curl,
    CURLOPT_HTTPHEADER,
    array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $CI->session->Token
    )
  );

  $response = array(
    "data" => json_decode(curl_exec($curl), TRUE),
    "status" => curl_getinfo($curl, CURLINFO_HTTP_CODE),
  );

  curl_close($curl);
  return $response;
}

function api_get($url)
{

  $curl = curl_init($url);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'x-api-key: apikey123'
  ));

  $response = array(
    "data" => json_decode(curl_exec($curl), TRUE),
    "status" => curl_getinfo($curl, CURLINFO_HTTP_CODE),
  );

  curl_close($curl);

  return $response;
}

function api_get_id($url, $id)
{
  $curl = curl_init($url . $id);
  $CI = &get_instance();

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $CI->session->Token
  ));

  $response = json_decode(curl_exec($curl), true);
  curl_close($curl);

  return $response;
}

function api_put($url, $data)
{
  $curl = curl_init($url);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  curl_setopt($curl, CURLOPT_HTTPHEADER, 
      array(
         'Content-Type: application/x-www-form-urlencoded',
         'x-api-key: apikey123'
      )
  );

  $response = array(
    "data" => json_decode(curl_exec($curl), TRUE),
    "status" => curl_getinfo($curl, CURLINFO_HTTP_CODE),
  );
  
  curl_close($curl);
  return $response;
}


function api_delete($url, $id)
{

  $curl = curl_init($url . $id);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'x-api-key: apikey123'
  ));

  $response = array(
    "data" => json_decode(curl_exec($curl), TRUE),
    "status" => curl_getinfo($curl, CURLINFO_HTTP_CODE),
  );
  curl_close($curl);
  return $response;
}
