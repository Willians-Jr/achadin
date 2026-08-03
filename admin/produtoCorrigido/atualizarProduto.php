<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduto   = (int) ($_POST['idProduto'] ?? 0);
    $idCategoria = (int) ($_POST['idCategoria'] ?? 0);
    $idLoja      = (int) ($_POST['idLoja'] ?? 0);
    $nomeProduto = trim($_POST['nomeProduto'] ?? '');
    $descricaoProduto = trim($_POST['descricaoProduto'] ?? '');
    $linkAfiliado     = trim($_POST['linkAfiliado'] ?? '');

    $precoProduto    = isset($_POST['precoProduto']) ? (float) $_POST['precoProduto'] : 0;
    $descontoProduto = isset($_POST['descontoProduto']) ? max(0, min(100, (int) $_POST['descontoProduto'])) : 0;
    $cashbackProduto = isset($_POST['cashbackProduto']) ? max(0, min(100, (int) $_POST['cashbackProduto'])) : 0;

    $fotoProduto = $_POST['fotoAtual'] ?? '';

    if ($nomeProduto === '' || $idCategoria === 0 || $idLoja === 0 || $idProduto === 0) {
        die("Todos os campos obrigatórios precisam ser preenchidos.");
    }

    if (isset($_FILES['fotoProduto']) && $_FILES['fotoProduto']['error'] == 0) {
        $pastaDestino = ROOT_PATH . "/assets/UPLOAD/";

        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        $extensao = strtolower(pathinfo($_FILES['fotoProduto']['name'], PATHINFO_EXTENSION));
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $extensoesPermitidas)) {
            $novoNome = uniqid('produto_') . '.' . $extensao;
            $caminhoCompleto = $pastaDestino . $novoNome;

            if (move_uploaded_file($_FILES['fotoProduto']['tmp_name'], $caminhoCompleto)) {
                $fotoProduto = 'assets/UPLOAD/' . $novoNome;
            }
        }
    }

    $sqlUpdate = "UPDATE produto SET
                    nomeProduto = ?,
                    idCategoria = ?,
                    idLoja = ?,
                    fotoProduto = ?,
                    descricaoProduto = ?,
                    linkAfiliado = ?,
                    precoProduto = ?,
                    descontoProduto = ?,
                    cashbackProduto = ?
                  WHERE idProduto = ?";

    $stmt = mysqli_prepare($conexao, $sqlUpdate);
    mysqli_stmt_bind_param(
        $stmt,
        "siisssdiii",
        $nomeProduto,
        $idCategoria,
        $idLoja,
        $fotoProduto,
        $descricaoProduto,
        $linkAfiliado,
        $precoProduto,
        $descontoProduto,
        $cashbackProduto,
        $idProduto
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location='gerenciarProduto.php';
              </script>";
        exit;
    } else {
        error_log("Erro ao atualizar produto: " . mysqli_error($conexao));
        die("Não foi possível realizar a edição.");
    }
}

$idProduto = (int) ($_GET['id'] ?? 0);

if ($idProduto === 0) {
    die("ID do produto inválido ou não informado.");
}

$sql = "SELECT * FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $dados = mysqli_fetch_assoc($result);
} else {
    die("Produto não encontrado.");
}
