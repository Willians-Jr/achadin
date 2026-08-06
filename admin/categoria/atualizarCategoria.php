<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();
require_once ROOT_PATH . '/includes/conexao.php';
exigirAdmin();

if (!isset($_POST['idCategoria'])) {
    die("ID da categoria não informado.");
}

if (!isset($_POST['nomeCategoria'])) {
    die("Nome da categoria não informado.");
}

$idCategoria = (int) $_POST['idCategoria'];
$nomeCategoria = trim($_POST['nomeCategoria']);

if ($idCategoria <= 0 || $nomeCategoria === '') {
    die("Dados inválidos enviados.");
}

$sql = "UPDATE categoria SET nomeCategoria = ? WHERE idCategoria = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "si", $nomeCategoria, $idCategoria);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Refresh:2; url=gerenciarCategoria.php");
    echo "Alteração realizada com sucesso!";
    exit;
} else {
    mysqli_stmt_close($stmt);
    error_log("Erro ao alterar categoria: " . mysqli_error($conexao));
    echo "Erro ao alterar categoria. Tente novamente mais tarde.";
    exit;
}
?>
