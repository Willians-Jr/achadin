<?php
    include_once __DIR__ . '/../../includes/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>

<form action="editarProduto.php" method="POST">
    <input type="hidden" name="idProduto" value="<?php echo $dados['idProduto']; ?>">

    <label for="nomeProduto">Produto</label>
    <input type="text" name="nomeProduto" id="nomeProduto">
    <br> <br>
    <label for="idCategoria">Categoria</label>
    <select name="idCategoria" id="idCategoria">
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
    <select name="idLoja" id="idLoja">
        <?php
        $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
        $resultLoja = mysqli_query($conexao, $sqlLoja);
        while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
            $selected = ($dadosLoja['idLoja'] == $dados['idLoja']) ? 'selected' : '';
            echo "<option value='" . $dadosLoja['idLoja'] . "' $selected>" . $dadosLoja['nomeLoja'] . "</option>";
        }
        ?>
    </select>

    <button type="submit">Atualizar</button>
</form>
</body>
</html>