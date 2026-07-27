<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
session_start();


// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
  header("Location:" . BASE_URL . "index.php");
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

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meu Perfil</title>
       

    
    
  </head>

  <body>
   <?php require_once ROOT_PATH . '/includes/header.php';
?>
    <main class="container mt-4">
      <h1 class="text-center mb-4">Meu Perfil</h1>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow p-3">
            <div class="text-center">
              <img
                src="<?php echo !empty($imgUsuario) ? 'imagens/' . $imgUsuario : 'BASE_URL img/download.png'; ?>"
                alt="Foto do usuário"
              />
            </div>

            <div class="mt-3">
              <p class="mb-1"><strong>Nome:</strong> <?php echo htmlspecialchars($nomeUsuario); ?></p>
              <p class="mb-1"><strong>Login:</strong> <?php echo htmlspecialchars($loginUsuario); ?></p>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card shadow p-4">
            <h2 class="mb-3">Editar perfil</h2>

            <form method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="nomeUsuario" class="form-label">Nome:</label>
                <input
                  type="text"
                  class="form-control"
                  id="nomeUsuario"
                  name="nomeUsuario"
                  value="<?php echo htmlspecialchars($nomeUsuario); ?>"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="loginUsuario" class="form-label">login</label>
                <input
                  type="text"
                  class="form-control"
                  id="loginUsuario"
                  name="loginUsuario"
                  value="<?php echo htmlspecialchars($loginUsuario); ?>"
                  required
                />
              </div>
              
            <div class="mb-3">
    <label for="imgUsuario" class="form-label">Foto do Usuário</label>

    <input
        type="file"
        class="form-control"
        id="imgUsuario"
        name="imgUsuario"
        accept="image/*">
</div>

              <button type="submit" class="btn btn-primary">Salvar alterações</button>
              <a href="<?= BASE_URL ?>index.php" class="btn btn-secondary ms-2">Voltar</a>
            </form>

            <?php if (isset($_SESSION['mensagemPerfil'])): ?>
              <div class="alert alert-info mt-3 mb-0">
                <?php echo $_SESSION['mensagemPerfil']; ?>
              </div>
              <?php unset($_SESSION['mensagemPerfil']); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </main>

   
  </body>
</html>

