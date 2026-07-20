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
    <title>Lojas</title>
  </head>
  <body>
    <h1>Lojas</h1>

    <form method="GET">
    <input
        type="search"
        name="pesquisaLoja"
        placeholder="Pesquisar loja..."
        value="<?php echo htmlspecialchars($pesquisaLoja); ?>">
    <button type="submit">
        Pesquisar
    </button>
</form>

<table>
  <tr>
    <th>Nome</th>
    <th>Logo</th>
    <th colspan="2">Atualizar</th>
  </tr>
<?php
while ($dados = mysqli_fetch_assoc($resultado)) { ?>
  <tr>
    <td><?php echo $dados['nomeLoja']; ?></td>
    <td><?php
        $sqlNome = "SELECT nomeLoja FROM loja WHERE idLoja = " . $dados['idLoja'];
        $resultNome = mysqli_query($conexao, $sqlnome);
        $dadosNome = mysqli_fetch_assoc($resultNome);
        echo $dadosNome['nomeLoja'];
        ?></td>
    <td><?php
        $sqlLogo = "SELECT logoLoja FROM loja WHERE idLoja = " . $dados['idLoja'];
        $resultLogo = mysqli_query($conexao, $sqlLogo);
        $dadosLogo = mysqli_fetch_assoc($resultLogo);
        // Requer atenção
        echo $dadosLogo['logoLoja'];
        ?></td>
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
  </body>
</html>
