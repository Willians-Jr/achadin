<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idCategoria = isset($_GET['idCategoria']) ? (int) $_GET['idCategoria'] : 0;

if ($idCategoria <= 0) {
    die("ID da categoria inválido.");
}

$sql = "DELETE FROM categoria WHERE idCategoria = $idCategoria";

if (mysqli_query($conexao, $sql)) {

    if (mysqli_affected_rows($conexao) > 0) {
        echo "Categoria excluída com sucesso! Redirecionando...";
    } else {
        echo "Categoria não encontrada.";
    }

    header("Refresh: 3; url=gerenciarCategoria.php");
    exit;

} else {

    echo "Não foi possível realizar a exclusão: " . mysqli_error($conexao);

}

mysqli_close($conexao);