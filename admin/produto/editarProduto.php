<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();

$dados = [
    'idProduto' => '',
    'nomeProduto' => '',
    'idCategoria' => '',
    'idLoja' => '',
    'linkAfiliado' => '',
    'descricaoProduto' => '',
    'fotoProduto' => ''
];

$idProduto = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($idProduto <= 0) {
    echo "<script>alert('ID do produto não informado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}

$sqlProduto = "SELECT idProduto, nomeProduto, idCategoria, idLoja, fotoProduto, linkAfiliado, descricaoProduto, idUsuario FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sqlProduto);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$resultProduto = mysqli_stmt_get_result($stmt);

if ($resultProduto && mysqli_num_rows($resultProduto) > 0) {
    $dados = mysqli_fetch_assoc($resultProduto);
} else {
    mysqli_stmt_close($stmt);
    echo "<script>alert('Produto não encontrado!'); window.location='gerenciarProduto.php';</script>";
    exit;
}
mysqli_stmt_close($stmt);

exigirDonoOuAdmin((int) $dados['idUsuario']);
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
    
    <input type="hidden" name="idProduto" value="<?php echo $dados['idProduto']; ?>">
    
    <input type="hidden" name="fotoAtual" value="<?php echo $dados['fotoProduto']; ?>">

    <label for="nomeProduto">Produto</label>
    <input type="text" name="nomeProduto" id="nomeProduto" value="<?php echo htmlspecialchars($dados['nomeProduto']); ?>" required>
    <br> <br>

    <label for="idCategoria">Categoria</label>
    <select name="idCategoria" id="idCategoria" required>
        <?php
        $sqlCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
        $resultCategoria = mysqli_query($conexao, $sqlCategoria);
        while ($dadosCategoria = mysqli_fetch_assoc($resultCategoria)) {
            $selected = ($dadosCategoria['idCategoria'] == $dados['idCategoria']) ? 'selected' : '';
            echo "<option value='" . $dadosCategoria['idCategoria'] . "' $selected>" . $dadosCategoria['nomeCategoria'] . "</option>";
        }
        ?>
    </select>
    <br> <br>

    <label for="idLoja">Loja</label>
    <select name="idLoja" id="idLoja" required>
        <?php
        $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
        $resultLoja = mysqli_query($conexao, $sqlLoja);
        while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
            $selected = ($dadosLoja['idLoja'] == $dados['idLoja']) ? 'selected' : '';
            echo "<option value='" . $dadosLoja['idLoja'] . "' $selected>" . $dadosLoja['nomeLoja'] . "</option>";
        }
        ?>
    </select>
    <br> <br>

    <label for="linkAfiliado">Link do Produto</label>
      <input type="text" name="linkAfiliado" id="linkAfiliado" value="<?php echo $dados['linkAfiliado'];?>">
      <br><br>

    <label for="descricaoProduto">Descrição do Produto</label>
      <input type="text" name="descricaoProduto" id="descricaoProduto" value="<?php echo $dados['descricaoProduto'];?>">
      <br><br>

    <label for="fotoProduto">Nova foto</label>
    <input type="file" name="fotoProduto" id="fotoProduto" accept="image/*">

    <?php if (!empty($dados['fotoProduto'])): ?>
        <br><br>
        <p>Foto atual:</p>
        <img src="../<?php echo $dados['fotoProduto']; ?>" alt="Foto atual" width="100" height="100" style="border-radius: 8px; object-fit: cover;">
    <?php endif; ?>

    <br><br>
    <button type="submit">Atualizar</button>
</form>

</body>
</html>
