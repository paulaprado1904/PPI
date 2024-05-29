<?php

require "../conexaoMysql.php";
require "cliente.php";

// resgata a ação a ser executada
$acao = $_GET['acao'];

// conecta ao servidor do MySQL
$pdo = mysqlConnect();

switch ($acao) {
  
  case "adicionarCliente":
    // recupera os dados do formulário
    $nome = $_POST["nome"] ?? "";
    $cpf = $_POST["cpf"] ?? "";
    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";
    $altura = $_POST["altura"] ?? "";
    $estadoCivil = $_POST["estadoCivil"] ?? "";
    $dataNascimento = $_POST["dataNascimento"] ?? "";

    // gera o hash da senha e cria um novo Cliente
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $novoCliente = new Cliente(
      $nome, $cpf, $email, $senhaHash,
      $dataNascimento, $estadoCivil, $altura
    );

    // adiciona o cliente na tabela do banco de dados
    $novoCliente->AddToDatabase($pdo);
    header("location: controlador.php?acao=listarClientes");
    break;

  //-----------------------------------------------------------------
  case "excluirCliente":
    $cpf = $_GET["cpf"] ?? "";
    $pdo = mysqlConnect();
    Cliente::RemoveByCPF($pdo, $cpf);
    header("location: controlador.php?acao=listarClientes");
    break;

  //-----------------------------------------------------------------
  case "listarClientes":
    $arrayClientes = Cliente::GetFirst30($pdo);
    
    // O script mostra-clientes.php produzirá uma página dinâmica
    // utilizando os dados do array acima ($arrayClientes)
    include "mostra-clientes.php";
    break;

  //-----------------------------------------------------------------
  default:
    exit("Ação não disponível");
}
