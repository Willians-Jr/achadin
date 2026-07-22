<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
require_once ROOT_PATH . '/includes/header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
    <h1>Registro de Produto</h1>
    <br>
    <form action="inserirProduto.php" method="post" enctype="multipart/form-data">
        <label for="nomeProduto">Nome do Produto</label>
        <input type="text" id="nomeProduto" name="nomeProduto" required>

            
        <br><br>

        <label for="idCategoria">Categoria</label>
        <select id="idCategoria" name="idCategoria" required>
            <?php
            $sqlCategoria = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
            $resultCategoria = mysqli_query($conexao, $sqlCategoria);
            while ($dadosCategoria = mysqli_fetch_assoc($resultCategoria)) {
                echo "<option value='" . $dadosCategoria['idCategoria'] . "'>" . $dadosCategoria['nomeCategoria'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="idLoja">Loja</label>
        <select id="idLoja" name="idLoja" required>
            <?php
            $sqlLoja = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
            $resultLoja = mysqli_query($conexao, $sqlLoja);
            while ($dadosLoja = mysqli_fetch_assoc($resultLoja)) {
                echo "<option value='" . $dadosLoja['idLoja'] . "'>" . $dadosLoja['nomeLoja'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="idUsuario">Usuário</label>
        <select id="idUsuario" name="idUsuario" required>
            <?php
            $sqlUsuario = "SELECT idUsuario, nomeUsuario FROM usuario ORDER BY nomeUsuario";
            $resultUsuario = mysqli_query($conexao, $sqlUsuario);
            while ($dadosUsuario = mysqli_fetch_assoc($resultUsuario)) {
                echo "<option value='" . $dadosUsuario['idUsuario'] . "'>" . $dadosUsuario['nomeUsuario'] . "</option>";
            }
            ?>
        </select><br><br>

        <label>
            Foto do Produto
        </label>
    
        <input
            type="file"
            id="fotoProduto"
            name="fotoProduto"
            accept=".jpg,.jpeg,.png,.gif,image/*">

        <br><br>

        <input type="submit" value="Registrar Produto">

    </form>

</body>
</html>

<?php require_once ROOT_PATH . '/includes/footer.php';?>