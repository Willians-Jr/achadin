<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idCategoria = $_GET['idCategoria'];
$nomeCategoria = $_POST['nomeCategoria'];


$sql = "UPDATE categoria SET nomeCategoria = '$nomeCategoria',  WHERE idCategoria = $idCategoria";

if(mysqli_query($conexao,$sql)){
  echo "Alteração realizada com sucesso!";
    header("refresh:2;url=gerenciarLoja.php");
}
else{
  echo "Não foi possivel realizar a alteração.";
}
?>