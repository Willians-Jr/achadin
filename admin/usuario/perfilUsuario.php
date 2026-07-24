<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
session_start();


// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
  header("Location: ../../index.php");
  exit;
}

$idUsuario = $_SESSION['idUsuario'];

// Busca dados do usuário logado
$sql = "SELECT nomeUsuario, loginUsuario, imgUsuario FROM usuario WHERE idUsuario = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
  die("Usuário não encontrado.");
}

$dados = mysqli_fetch_assoc($resultado);
$nomeUsuario = $dados['nomeUsuario'] ?? '';
$loginUsuario = $dados['loginUsuario'] ?? '';
$imgUsuario = $dados['imgUsuario'] ?? '';

// Atualiza nome/login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $novoNome = trim($_POST['nomeUsuario'] ?? '');
  $novoLogin = trim($_POST['loginUsuario'] ?? '');
  $nomeImagem=$imgUsuario;

 if (isset($_FILES['imgUsuario']) && $_FILES['imgUsuario']['error'] == 0) {

    $arquivo = $_FILES['imgUsuario'];

    $nomeImagem = time() . "_" . basename($arquivo['name']);

    $caminho = "imagens/" . $nomeImagem;

    move_uploaded_file($arquivo['tmp_name'], $caminho);
}

  if ($novoNome === '' || $novoLogin === '') {
    $_SESSION['mensagemPerfil'] = "Nome e login são obrigatórios.";
    header("Location: perfilUsuario.php");
    exit;
  }

  $sqlUpd = "UPDATE usuario
           SET nomeUsuario = ?, loginUsuario = ?, imgUsuario = ?
           WHERE idUsuario = ?";

$stmtUpd = mysqli_prepare($conexao, $sqlUpd);

mysqli_stmt_bind_param(
    $stmtUpd,
    "sssi",
    $novoNome,
    $novoLogin,
    $nomeImagem,
    $idUsuario
);

  if (mysqli_stmt_execute($stmtUpd)) {
    $_SESSION['mensagemPerfil'] = "Perfil atualizado com sucesso!";
  } else {
    $_SESSION['mensagemPerfil'] = "Erro ao atualizar perfil.";
  }

  header("Location: perfilUsuario.php");
  exit;
}

?>

