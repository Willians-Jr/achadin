<?php
require_once dirname(__DIR__, 2) . '/includes/auth.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

$pesquisaCategoria = isset($_GET['pesquisaCategoria']) ? trim($_GET['pesquisaCategoria']) : '';

if ($pesquisaCategoria !== '') {
    $sql  = "SELECT * FROM categoria WHERE nomeCategoria LIKE CONCAT('%', ?, '%') ORDER BY nomeCategoria ASC";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $pesquisaCategoria);
} else {
    $sql  = "SELECT * FROM categoria ORDER BY nomeCategoria ASC";
    $stmt = mysqli_prepare($conexao, $sql);
}

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Categorias</title>
  </head>
  <body>
    <h1>Categorias</h1>

    <form method="GET">
    <input
        type="search"
        name="pesquisaCategoria"
        placeholder="Pesquisar Categoria..."
        value="<?php echo htmlspecialchars($pesquisaCategoria); ?>">
    <button type="submit">
        Pesquisar Categoria
    </button>
</form>

<table border="1">
<tr>
    <th>Nome</th>
    <th>Alterar</th>
    <th>Excluir</th>
</tr>

<?php while ($dados = mysqli_fetch_assoc($resultado)) { ?>

<tr>
    <td><?php echo htmlspecialchars($dados['nomeCategoria']); ?></td>

    <td>
        <a href="editarCategoria.php?idCategoria=<?php echo (int) $dados['idCategoria']; ?>">
            Alterar
        </a>
    </td>

    <td>
        <a href="excluirCategoria.php?idCategoria=<?php echo (int) $dados['idCategoria']; ?>"
           onclick="return confirm('Deseja realmente excluir esta categoria?')">
            Excluir
        </a>
    </td>
</tr>

<?php } ?>

</table>
  </body>
</html>
