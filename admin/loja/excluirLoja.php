<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idLoja = $_GET['idLoja'] ?? 0;

$sql = "DELETE FROM loja WHERE idLoja = $idLoja";

if (mysqli_query($conexao, $sql)) {
      echo "Excluído com sucesso!";
      header("refresh:3;url=gerenciarLoja.php");
  } else {
      echo "Não foi possível realizar a exclusão: " . mysqli_error($conexao);
  }
?>