<?php
  include_once __DIR__ . "/../../includes/conexao.php";

  $idProduto = $_GET['id'] ?? 0;

  $sql = "DELETE FROM produto WHERE idProduto = $idProduto";

  if (mysqli_query($conexao, $sql)) {
      echo "Excluído com sucesso!";
      header("refresh:3;url=index.php");
  } else {
      echo "Não foi possível realizar a exclusão: " . mysqli_error($conexao);
  }
?>