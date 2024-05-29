<?php

class Produto
{
  public $nome;
  public $marca;
  public $descricao;

  function __construct($nome, $marca, $descricao)
  {
    $this->nome = $nome;
    $this->marca = $marca;
    $this->descricao = $descricao;}

  // Adiciona os dados do objeto (cliente)
  // na tabela cliente do banco de dados
  public function AddToDatabase($pdo)
  {
    try {
      $sql = <<<SQL
      -- Repare que a coluna Id foi omitida por ser auto_increment
      INSERT INTO produtos (nome, marca, descricao)
      VALUES (?, ?, ?)
      SQL;

      // Neste caso utilize prepared statements para prevenir
      // inj. de S Q L, pois precisamos
      // cadastrar dados fornecidos pelo usuário 
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        $this->nome, $this->marca, $this->descricao
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
      SELECT nome, marca,descricao
      FROM produtos
      LIMIT 30
      SQL;

      // Neste exemplo não é necessário utilizar prepared statements
      // porque não há a possibilidade de inj. de S Q L, 
      // pois nenhum parâmetro do usuário é utilizado na query SQL. 
      $stmt = $pdo->query($sql);

      $arrayProdutos = [];
      while ($row = $stmt->fetch()) {
        // Sanitiza os dados produzidos pelo usuário
        // que oferecem risco de X S S
        $nome = htmlspecialchars($row['nome']);
        $marca = htmlspecialchars($row['marca']);
        $descricao = htmlspecialchars($row['descricao']);

        // Cria um novo objeto do tipo Cliente e adiciona
        // no final do array de clientes
        $novoProduto = new Produto(
          $nome,
          $marca,
          $descricao
        );
        $arrayProdutos[] = $novoProduto;
      }
      return $arrayProdutos;
    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }

  // Método estático para excluir um cliente dado o seu CPF
  public static function RemoveByNome($pdo, $nome)
  {
    try {
      $sql = <<<SQL
      DELETE FROM produtos
      WHERE nome = ?
      LIMIT 1
      SQL;

      // Necessário utilizar prepared statements devido ao parâmetro
      // informado pelo usuário
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$nome]);
    } catch (Exception $e) {
      exit('Falha inesperada: ' . $e->getMessage());
    }
  }
}
