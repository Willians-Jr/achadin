<?php
include_once __DIR__ . '/../../includes/conexao.php';

$pesquisaLoja = isset($_GET['pesquisaLoja']) ? $_GET['pesquisaLoja'] : '';

if ($pesquisaLoja) {
    $sql = "SELECT * FROM loja WHERE nomeLoja LIKE '%$pesquisaLoja%'
    ORDER BY nomeLoja ASC";
} else {
    $sql = "SELECT * FROM loja";
}

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    die("Erro ao buscar a loja: " . mysqli_error($conexao));
}
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lojas - Gerenciar</title>
  </head>
  <body>
    <h1>Tabela de Gerenciamento de Lojas</h1>

    <form method="GET">
    <input
        type="search"
        name="pesquisaLoja"
        placeholder="Pesquisar loja..."
        value="<?php echo htmlspecialchars($pesquisaLoja); ?>">
    <button type="submit">
        Pesquisar
    </button>

    <table border="1">
  <tr>
    <th>Nome</th>
    <th>Logo</th>
    <th colspan="2">Ações</th>
  </tr>
<?php
while ($dados = mysqli_fetch_assoc($resultado)) { ?>
  <tr>
    <td><?php echo $dados['nomeLoja']; ?></td>

    <td><img src="../../assets/UPLOAD/<?php echo $dados['logoLoja']; ?>" alt="Logo da Loja" width="100" /></td>
    <br><br>
    
    <td><a href="editarLoja.php?id=<?php echo $dados['idLoja']; ?>">Alterar</a></td>
    <td>
      <a href="excluirLoja.php?id=<?php echo $dados['idLoja']; ?>"
         onclick="return confirm('Deseja realmente excluir esta loja?')">
        Excluir
      </a>
    </td>
  </tr>
<?php } ?>
</table>
</form>
  </body>
</html>
