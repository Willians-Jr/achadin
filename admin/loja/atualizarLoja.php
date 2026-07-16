<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idLoja = $_GET['idLoja'];
$nomeLoja = $_POST['nomeLoja'];
$logoLoja = $_POST['logoLoja'];

$sql = "UPDATE loja SET nomeLoja = '$nomeLoja', logoLoja = '$logoLoja' WHERE idLoja = $idLoja";

if(mysqli_query($conexao,$sql)){
  echo "Alteração realizada com sucesso!";
    header("refresh:2;url=gerenciarLoja.php");
}
else{
  echo "Não foi possivel realizar a alteração.";
}
?>