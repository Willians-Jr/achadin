<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
exigirLogin();
require_once ROOT_PATH . '/includes/conexao.php';

$idLoja = isset($_GET['idLoja']) ? (int) $_GET['idLoja'] : 0;

if ($idLoja <= 0) {
    die("ID da loja inválido.");
}

$sql = "DELETE FROM loja WHERE idLoja = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idLoja);

if (mysqli_stmt_execute($stmt)) {
      echo "Excluído com sucesso!";
      mysqli_stmt_close($stmt);
      header("refresh:3;url=gerenciarLoja.php");
      exit;
  } else {
      error_log("Erro ao excluir loja: " . mysqli_stmt_error($stmt));
      mysqli_stmt_close($stmt);
      echo "Não foi possível realizar a exclusão. Tente novamente mais tarde.";
      exit;
  }
?>
