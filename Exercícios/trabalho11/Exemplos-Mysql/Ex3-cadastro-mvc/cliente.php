<?php

class Cliente
{
  public $nome;
  public $cpf;
  public $email;
  public $senhaHash;
  public $dataNascimento;
  public $estadoCivil;
  public $altura;

  function __construct($nome, $cpf, $email, $senhaHash, $dataNascimento, $estadoCivil, $altura)
  {
    $this->nome = $nome;
    $this->cpf = $cpf;
    $this->email = $email;
    $this->senhaHash = $senhaHash;
    $this->dataNascimento = $dataNascimento;
    $this->estadoCivil = $estadoCivil;
    $this->altura = $altura;
  }

  // Adiciona os dados do objeto (cliente)
  // na tabela cliente do banco de dados
  public function AddToDatabase($pdo)
  {
    try {
      $sql = <<<SQL
      -- Repare que a coluna Id foi omitida por ser auto_increment
      INSERT INTO cliente (nome, cpf, email, hash_senha, 
                           data_nascimento, estado_civil, altura)
      VALUES (?, ?, ?, ?, ?, ?, ?)
      SQL;

      // Neste caso utilize prepared statements para prevenir
      // inj. de S Q L, pois precisamos
      // cadastrar dados fornecidos pelo usuário 
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        $this->nome, $this->cpf, $this->email, $this->senhaHash,
        $this->dataNascimento, $this->estadoCivil, $this->altura
      ]);
    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }

  // Método estático para retornar, na forma de um
  // array de objetos, os 30 clientes iniciais da tabela.
  // O método retorna os dados sanitizados e com a data
  // de nascimento no formato dia/mês/ano. Métodos estáticos
  // estão associados à classe em si, e não a uma instância.
  // No PHP devem ser chamados com a sintaxe:
  // NomeDaClasse::NomeDoMétodo
  public static function GetFirst30($pdo)
  {
    try {
      $sql = <<<SQL
      SELECT nome, cpf, email, hash_senha, 
             data_nascimento, estado_civil, altura
      FROM cliente
      LIMIT 30
      SQL;

      // Neste exemplo não é necessário utilizar prepared statements
      // porque não há a possibilidade de inj. de S Q L, 
      // pois nenhum parâmetro do usuário é utilizado na query SQL. 
      $stmt = $pdo->query($sql);

      $arrayClientes = [];
      while ($row = $stmt->fetch()) {
        // Sanitiza os dados produzidos pelo usuário
        // que oferecem risco de X S S
        $nome = htmlspecialchars($row['nome']);
        $cpf = htmlspecialchars($row['cpf']);
        $email = htmlspecialchars($row['email']);
        $estadoCivil = htmlspecialchars($row['estado_civil']);

        $hashSenha = $row['hash_senha'];
        $altura = $row['altura'];

        // Converte a data para o formato dia/mês/ano
        $data = new DateTime($row['data_nascimento']);
        $dataFormatoDiaMesAno = $data->format('d-m-Y');

        // Cria um novo objeto do tipo Cliente e adiciona
        // no final do array de clientes
        $novoCliente = new Cliente(
          $nome,
          $cpf,
          $email,
          $hashSenha,
          $dataFormatoDiaMesAno,
          $estadoCivil,
          $altura
        );
        $arrayClientes[] = $novoCliente;
      }
      return $arrayClientes;
    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }

  // Método estático para excluir um cliente dado o seu CPF
  public static function RemoveByCPF($pdo, $cpf)
  {
    try {
      $sql = <<<SQL
      DELETE FROM cliente
      WHERE cpf = ?
      LIMIT 1
      SQL;

      // Necessário utilizar prepared statements devido ao parâmetro
      // informado pelo usuário
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$cpf]);
    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }
}
