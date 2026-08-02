<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

$dados = [
    'idProduto'        => '',
    'nomeProduto'      => '',
    'idCategoria'      => '',
    'idLoja'           => '',
    'linkAfiliado'     => '',
    'descricaoProduto' => '',
    'fotoProduto'      => '',
    'precoProduto'     => 0,
    'descontoProduto'  => 0,
    'cashbackProduto'  => 0,
];

if (!isset($_GET['id'])) {
    echo "<script>alert('ID do produto não informado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}

$idProduto = (int) $_GET['id'];

$sqlProduto = "SELECT idProduto, nomeProduto, idCategoria, idLoja, fotoProduto, linkAfiliado,
                       descricaoProduto, precoProduto, descontoProduto, cashbackProduto
                FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sqlProduto);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$resultProduto = mysqli_stmt_get_result($stmt);

if ($resultProduto && mysqli_num_rows($resultProduto) > 0) {
    $dados = mysqli_fetch_assoc($resultProduto);
} else {
    echo "<script>alert('Produto não encontrado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>

<form action="atualizarProduto.php" method="POST" enctype="multipart/form-data">

    <input type="hidden" name="idProduto" value="<?php echo (int) $dados['idProduto']; ?>">
    <input type="hidden" name="fotoAtual" value="<?php echo htmlspecialchars($dados['fotoProduto']); ?>">

    <label for="nomeProduto">Produto</label>
    <input type="text" name="nomeProduto" id="nomeProduto" value="<?php echo htmlspecialchars($dados['nomeProduto']); ?>" required>
    <br><br>

    <label for="idCategoria">Categoria</label>
    <select name="idCategoria" id="idCategoria" required>
        <?php
        $sqlCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
        $resultCategoria = mysqli_query($conexao, $sqlCategoria);
        while ($dadosCategoria = mysqli_fetch_assoc($resultCategoria)) {
            $selected = ($dadosCategoria['idCategoria'] == $dados['idCategoria']) ? 'selected' : '';
            echo "<option value='" . (int) $dadosCategoria['idCategoria'] . "' $selected>" . htmlspecialchars($dadosCategoria['nomeCategoria']) . "</option>";
        }
        ?>
    </select>
    <br><br>

    <label for="idLoja">Loja</label>
    <select name="idLoja" id="idLoja" required>
        <?php
        $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
        $resultLoja = mysqli_query($conexao, $sqlLoja);
        while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
            $selected = ($dadosLoja['idLoja'] == $dados['idLoja']) ? 'selected' : '';
            echo "<option value='" . (int) $dadosLoja['idLoja'] . "' $selected>" . htmlspecialchars($dadosLoja['nomeLoja']) . "</option>";
        }
        ?>
    </select>
    <br><br>

    <label for="descricaoProduto">Descrição do Produto</label>
    <input type="text" name="descricaoProduto" id="descricaoProduto" value="<?php echo htmlspecialchars($dados['descricaoProduto']); ?>">
    <br><br>

    <label for="precoProduto">Preço (R$)</label>
    <input type="number" step="0.01" min="0" name="precoProduto" id="precoProduto" value="<?php echo htmlspecialchars($dados['precoProduto']); ?>" required>
    <br><br>

    <label for="descontoProduto">Desconto (%)</label>
    <input type="number" step="1" min="0" max="100" name="descontoProduto" id="descontoProduto" value="<?php echo (int) $dados['descontoProduto']; ?>" required>
    <br><br>

    <label for="cashbackProduto">Cashback (%)</label>
    <input type="number" step="1" min="0" max="100" name="cashbackProduto" id="cashbackProduto" value="<?php echo (int) $dados['cashbackProduto']; ?>" required>
    <br><br>

    <label for="linkAfiliado">Link do Produto</label>
    <input type="text" name="linkAfiliado" id="linkAfiliado" value="<?php echo htmlspecialchars($dados['linkAfiliado']); ?>">
    <br><br>

    <label for="fotoProduto">Nova foto</label>
    <input type="file" name="fotoProduto" id="fotoProduto" accept="image/*">

    <?php if (!empty($dados['fotoProduto'])): ?>
        <br><br>
        <p>Foto atual:</p>
        <img src="<?= BASE_URL ?><?php echo htmlspecialchars($dados['fotoProduto']); ?>" alt="Foto atual" width="100" height="100" style="border-radius: 8px; object-fit: cover;">
    <?php endif; ?>

    <br><br>
    <button type="submit">Atualizar</button>
</form>

</body>
</html>
