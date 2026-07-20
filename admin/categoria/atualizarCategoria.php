<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idCategoria = (int) $_GET['idCategoria'];
$nomeCategoria = mysqli_real_escape_string($conexao, $_POST['nomeCategoria']);

$sql = "UPDATE categoria
        SET nomeCategoria = '$nomeCategoria'
        WHERE idCategoria = $idCategoria";

if (mysqli_query($conexao, $sql)) {
    header("Refresh: 2; URL=gerenciarCategoria.php");
    echo "Alteração realizada com sucesso!";
} else {
    echo "Não foi possível realizar a alteração: " . mysqli_error($conexao);
}
?>