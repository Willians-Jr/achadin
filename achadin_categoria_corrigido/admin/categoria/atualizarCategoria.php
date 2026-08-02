<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();

require_once ROOT_PATH . '/includes/conexao.php';

if (!isset($_POST['idCategoria']) || !isset($_POST['nomeCategoria'])) {
    die("Dados incompletos.");
}

$idCategoria   = (int) $_POST['idCategoria'];
$nomeCategoria = trim($_POST['nomeCategoria']);

if (empty($nomeCategoria)) {
    die("Informe o nome da categoria.");
}

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql  = "UPDATE categoria SET nomeCategoria = ? WHERE idCategoria = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "si", $nomeCategoria, $idCategoria);

if (mysqli_stmt_execute($stmt)) {
    header("Refresh:2; url=gerenciarCategoria.php");
    echo "Alteração realizada com sucesso!";
} else {
    echo "Erro ao alterar categoria.";
}

mysqli_stmt_close($stmt);
mysqli_close($conexao);
