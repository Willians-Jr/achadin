<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

$pesquisaLoja = trim($_GET['pesquisaLoja'] ?? '');

if ($pesquisaLoja !== '') {
    $sql = "SELECT * FROM loja WHERE nomeLoja LIKE ? ORDER BY nomeLoja ASC";
    $stmt = mysqli_prepare($conexao, $sql);
    $like = "%{$pesquisaLoja}%";
    mysqli_stmt_bind_param($stmt, "s", $like);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
} else {
    $sql = "SELECT * FROM loja ORDER BY nomeLoja ASC";
    $resultado = mysqli_query($conexao, $sql);
}

if (!$resultado) {
    die("Erro ao buscar a loja.");
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
        value="<?php echo htmlspecialchars($pesquisaLoja, ENT_QUOTES, 'UTF-8'); ?>">
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
    <td><?php echo htmlspecialchars($dados['nomeLoja'], ENT_QUOTES, 'UTF-8'); ?></td>

    <td><img src="<?= BASE_URL ?>assets/UPLOAD/<?php echo htmlspecialchars($dados['logoLoja'], ENT_QUOTES, 'UTF-8'); ?>" alt="Logo da Loja" width="100" /></td>
    <td><a href="editarLoja.php?id=<?php echo (int) $dados['idLoja']; ?>">Alterar</a></td>
    <td>
      <a href="excluirLoja.php?idLoja=<?php echo (int) $dados['idLoja']; ?>"
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
