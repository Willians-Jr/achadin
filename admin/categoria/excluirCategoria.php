<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();
require_once ROOT_PATH . '/includes/conexao.php';
exigirAdmin();

$idCategoria = isset($_GET['idCategoria']) ? (int) $_GET['idCategoria'] : 0;

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql = "DELETE FROM categoria WHERE idCategoria = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idCategoria);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Categoria excluída com sucesso! Redirecionando...";
    } else {
        echo "Categoria não encontrada.";
    }
    mysqli_stmt_close($stmt);
    header("Refresh: 3; url=gerenciarCategoria.php");
    exit;
} else {
    error_log("Erro ao excluir categoria: " . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    echo "Não foi possível realizar a exclusão. Tente novamente mais tarde.";
    exit;
}

mysqli_close($conexao);