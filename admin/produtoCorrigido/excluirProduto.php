<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

$idProduto = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($idProduto <= 0) {
    die("ID do produto inválido.");
}

$sql  = "DELETE FROM produto WHERE idProduto = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idProduto);

if (mysqli_stmt_execute($stmt)) {
    echo "Excluído com sucesso!";
    header("refresh:3;url=gerenciarProduto.php");
} else {
    echo "Não foi possível realizar a exclusão.";
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
