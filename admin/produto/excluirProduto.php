<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

  $idProduto = $_GET['id'] ?? 0;

  $sql = "DELETE FROM produto WHERE idProduto = $idProduto";

  if (mysqli_query($conexao, $sql)) {
      echo "Excluído com sucesso!";
      header("refresh:3;url=index.php");
  } else {
      echo "Não foi possível realizar a exclusão: " . mysqli_error($conexao);
  }
?>