<?php
include_once __DIR__ . '/../../includes/conexao.php';

$dados = [
    'idProduto' => '',
    'nomeProduto' => '',
    'idCategoria' => '',
    'idLoja' => '',
    'fotoProduto' => ''
];

if (isset($_GET['id'])) {
    $idProduto = mysqli_real_escape_string($conexao, $_GET['id']);
    
    $sqlProduto = "SELECT idProduto, nomeProduto, idCategoria, idLoja, fotoProduto FROM produto WHERE idProduto = '$idProduto'";
    $resultProduto = mysqli_query($conexao, $sqlProduto);
    
    if ($resultProduto && mysqli_num_rows($resultProduto) > 0) {
        $dados = mysqli_fetch_assoc($resultProduto);
    } else {
        echo "<script>alert('Produto não encontrado!'); window.location='gerenciarProduto.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID do produto não informado!'); window.location='gerenciarProduto.php';</script>";
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

<form action="atualizarProduto.php" method="POST">
    
    <input type="hidden" name="idProduto" value="<?php echo $dados['idProduto']; ?>">

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