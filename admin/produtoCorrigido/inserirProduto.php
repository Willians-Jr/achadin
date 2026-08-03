<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto      = trim($_POST['nomeProduto'] ?? '');
    $idCategoria      = (int) ($_POST['idCategoria'] ?? 0);
    $idLoja           = (int) ($_POST['idLoja'] ?? 0);
    $idUsuario        = (int) ($_POST['idUsuario'] ?? 0);
    $descricaoProduto = trim($_POST['descricaoProduto'] ?? '');
    $linkAfiliado     = trim($_POST['linkAfiliado'] ?? '');

    $precoProduto    = isset($_POST['precoProduto']) ? (float) $_POST['precoProduto'] : 0;
    $descontoProduto = isset($_POST['descontoProduto']) ? max(0, min(100, (int) $_POST['descontoProduto'])) : 0;
    $cashbackProduto = isset($_POST['cashbackProduto']) ? max(0, min(100, (int) $_POST['cashbackProduto'])) : 0;

    if ($nomeProduto === '' || $idCategoria === 0 || $idLoja === 0 || $idUsuario === 0) {
        die("Preencha todos os campos obrigatórios.");
    }

    $fotoProduto = "";

    if (isset($_FILES["fotoProduto"]) && $_FILES["fotoProduto"]["error"] == 0) {
        $pastaDestino = ROOT_PATH . "/assets/UPLOAD/";
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $extensao = strtolower(pathinfo($_FILES["fotoProduto"]["name"], PATHINFO_EXTENSION));
        $extensoesPermitidas = ["jpg", "jpeg", "png", "gif"];

        if (in_array($extensao, $extensoesPermitidas)) {
            $novoNome = uniqid("produto_") . "." . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;
            if (move_uploaded_file($_FILES["fotoProduto"]["tmp_name"], $caminhoCompleto)) {
                $fotoProduto = "assets/UPLOAD/" . $novoNome;
            }
        }
    }

    $sqlInsert = "INSERT INTO produto
                    (nomeProduto, idCategoria, idLoja, idUsuario, fotoProduto, descricaoProduto, linkAfiliado, precoProduto, descontoProduto, cashbackProduto)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexao, $sqlInsert);
    mysqli_stmt_bind_param(
        $stmt,
        "siiisssdii",
        $nomeProduto,
        $idCategoria,
        $idLoja,
        $idUsuario,
        $fotoProduto,
        $descricaoProduto,
        $linkAfiliado,
        $precoProduto,
        $descontoProduto,
        $cashbackProduto
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: gerenciarProduto.php");
        exit;
    } else {
        error_log("Erro ao cadastrar produto: " . mysqli_error($conexao));
        echo "Erro ao cadastrar produto. Tente novamente.";
    }

    mysqli_stmt_close($stmt);
}
