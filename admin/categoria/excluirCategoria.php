
<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idCategoria = $_GET['idCategoria'] ?? 0;

$sql = "DELETE FROM categoria WHERE idCategoria = $idCategoria";

if (mysqli_query($conexao, $sql)) {
      echo "Excluído com sucesso!";
      header("refresh:3;url=gerenciarCategoria.php");
  } else {
      echo "Não foi possível realizar a exclusão: " . mysqli_error($conexao);
  }
?>
