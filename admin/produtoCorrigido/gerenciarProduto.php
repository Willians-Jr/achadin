<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

$pesquisaProduto = isset($_GET['pesquisaProduto']) ? trim($_GET['pesquisaProduto']) : '';

$sqlBase = "SELECT p.*, c.nomeCategoria, l.nomeLoja
            FROM produto p
            INNER JOIN categoria c ON p.idCategoria = c.idCategoria
            INNER JOIN loja l ON p.idLoja = l.idLoja";

if ($pesquisaProduto !== '') {
    $sql  = $sqlBase . " WHERE p.nomeProduto LIKE CONCAT('%', ?, '%') ORDER BY p.nomeProduto";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $pesquisaProduto);
} else {
    $sql  = $sqlBase . " ORDER BY p.nomeProduto";
    $stmt = mysqli_prepare($conexao, $sql);
}

mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <title>Produtos ADM - Top Achados</title>
</head>
<body>

<h1>Produtos</h1>

<form method="GET">
    <input
        type="text"
        name="pesquisaProduto"
        placeholder="Pesquisar produto..."
        value="<?php echo htmlspecialchars($pesquisaProduto); ?>">
    <button type="submit">Pesquisar</button>
</form>

<br>
<table border="1">
    <tr>
        <th>Foto</th>
        <th>Nome</th>
        <th>Loja</th>
        <th>Categoria</th>
        <th>Preço</th>
        <th>Desconto</th>
        <th>Cashback</th>
        <th>Alterar</th>
        <th>Excluir</th>
    </tr>
    <?php while ($dados = mysqli_fetch_assoc($resultado)) { ?>
      <tr>
        <td>
            <?php if (!empty($dados['fotoProduto']) && file_exists(ROOT_PATH . "/" . $dados['fotoProduto'])): ?>
                <img src="<?= BASE_URL ?><?php echo htmlspecialchars($dados['fotoProduto']); ?>" alt="Foto do produto" width="50" height="50" style="object-fit: cover;">
            <?php else: ?>
                <span>Sem foto</span>
            <?php endif; ?>
        </td>

        <td><?php echo htmlspecialchars($dados['nomeProduto']); ?></td>
        <td><?php echo htmlspecialchars($dados['nomeLoja']); ?></td>
        <td><?php echo htmlspecialchars($dados['nomeCategoria']); ?></td>
        <td>R$ <?php echo number_format((float) $dados['precoProduto'], 2, ',', '.'); ?></td>
        <td><?php echo (int) $dados['descontoProduto']; ?>%</td>
        <td><?php echo (int) $dados['cashbackProduto']; ?>%</td>

        <td>
            <a href="editarProduto.php?id=<?php echo (int) $dados['idProduto']; ?>">Alterar</a>
        </td>
        <td>
          <a href="excluirProduto.php?id=<?php echo (int) $dados['idProduto']; ?>"
             onclick="return confirm('Deseja realmente excluir este produto?')">
            Excluir
          </a>
        </td>
      </tr>
    <?php } ?>
</table>

</body>
</html>
