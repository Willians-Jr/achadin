<?php
include_once __DIR__ . '/../../includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto = $_POST['nomeProduto'] ?? '';
    $idCategoria = $_POST['idCategoria'] ?? '';
    $idLoja = $_POST['idLoja'] ?? '';
    $idUsuario = $_POST['idUsuario'] ?? '';

    $sqlInsert = "INSERT INTO produto (nomeProduto, idCategoria, idLoja, idUsuario) VALUES ('$nomeProduto', '$idCategoria', '$idLoja', '$idUsuario')";

    $fotoProduto = "";
    if (isset($_FILES["fotoProduto"]) && $_FILES["fotoProduto"]["error"] == 0) {
        $pastaDestino = "../assets/UPLOAD/";
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }
        $nomeOriginal = $_FILES["fotoProduto"]["name"];
        $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
        $extensoesPermitidas = ["jpg", "jpeg", "png", "gif"];
        if (in_array($extensao, $extensoesPermitidas)) {
            $novoNome = uniqid("produto_") . "." . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;
            if (move_uploaded_file($_FILES["fotoProduto"]["tmp_name"], $caminhoCompleto)) {
                $fotoProduto = "assets/UPLOAD/" . $novoNome;
            }
        }
    }

    if (mysqli_query($conexao, $sqlInsert)) {
        echo "<script>
                alert('Produto cadastrado com sucesso!');
                window.location='gerenciarProduto.php';
              </script>";
    } else {
        echo "Erro ao cadastrar produto: " . mysqli_error($conexao) . "<br><br>";
    }
}

$sql = "SELECT c.nomeCategoria, l.nomeLoja, u.nomeUsuario, p.nomeProduto
        FROM produto p
        INNER JOIN categoria c ON p.idCategoria = c.idCategoria
        INNER JOIN loja l ON p.idLoja = l.idLoja
        INNER JOIN usuario u ON p.idUsuario = u.idUsuario
        ORDER BY p.idProduto DESC";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Produto</title>
</head>
<body>
    <h1>Registro de Produto</h1>
    <br>
    <form action="inserirProduto.php" method="post">
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