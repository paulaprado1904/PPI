<?php

$cep = $_GET['cep'] ?? ''; // recupera o parâmetro 'cep' enviado via GET. Se não preencher, deixa a string vazia.

if ($cep == '38400-100') // verifica o valor do CEP para determinar a cidade correspondente.
  echo 'Uberlândia';   // se o CEP for '38400-100', printa 'Uberlândia'.
else if ($cep == '38700-000')
  echo 'Patos de Minas'; // se o CEP for '38700-000', printa 'Patos de Minas'.
else {
  // Se o CEP não corresponder a nenhum dos valores acima, define HTTP 404 (não encontrado)
  // e printa uma mensagem que o CEP não está disponível.
  http_response_code(404);
  echo "$cep is not available";
}
