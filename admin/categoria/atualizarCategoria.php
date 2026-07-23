<?php
include_once __DIR__ . '/../../includes/conexao.php';

if (!isset($_POST['idCategoria'])) {
    die("ID da categoria não informado.");
}

if (!isset($_POST['nomeCategoria'])) {
    die("Nome da categoria não informado.");
}

$idCategoria = (int) $_POST['idCategoria'];
$nomeCategoria = mysqli_real_escape_string($conexao, $_POST['nomeCategoria']);

$sql = "UPDATE categoria
        SET nomeCategoria = '$nomeCategoria'
        WHERE idCategoria = $idCategoria";

if (mysqli_query($conexao, $sql)) {

    header("Refresh:2; url=gerenciarCategoria.php");
    echo "Alteração realizada com sucesso!";

} else {

    echo "Erro ao alterar: " . mysqli_error($conexao);

}
?>