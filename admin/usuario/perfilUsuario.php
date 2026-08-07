<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';


// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
  header("Location:" . BASE_URL . "index.php");
  exit;
}

$idUsuario = $_SESSION['idUsuario'];

// Busca dados do usuário logado
$sql = "SELECT nomeUsuario, emailUsuario, imgUsuario FROM usuario WHERE idUsuario = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idUsuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
  die("Usuário não encontrado.");
}

$dados = mysqli_fetch_assoc($resultado);
$nomeUsuario = $dados['nomeUsuario'] ?? '';
$emailUsuario = $dados['emailUsuario'] ?? '';
$imgUsuario = $dados['imgUsuario'] ?? '';

// Atualiza nome/email
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $novoNome = trim($_POST['nomeUsuario'] ?? '');
  $novoemail = trim($_POST['emailUsuario'] ?? '');
  $nomeImagem=$imgUsuario;

if (isset($_FILES['imgUsuario']) && $_FILES['imgUsuario']['error'] == 0) {

    $arquivo = $_FILES['imgUsuario'];

    // Limite de tamanho (2MB)
    $tamanhoMaximo = 2 * 1024 * 1024;
    if ($arquivo['size'] > $tamanhoMaximo) {
        $_SESSION['mensagemPerfil'] = "Imagem muito grande. Máximo de 2MB.";
        header("Location: perfilUsuario.php");
        exit;
    }

    // Verifica o tipo REAL do arquivo (não confia na extensão nem no header do navegador)
    $mimesPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeReal = finfo_file($finfo, $arquivo['tmp_name']);
    finfo_close($finfo);

    if (!array_key_exists($mimeReal, $mimesPermitidos)) {
        $_SESSION['mensagemPerfil'] = "Formato de imagem inválido.";
        header("Location: perfilUsuario.php");
        exit;
    }

    // Extensão derivada do MIME real verificado, não do nome enviado pelo usuário
    $extensao = $mimesPermitidos[$mimeReal];
    $nomeImagem = uniqid('perfil_', true) . "." . $extensao;

    $caminho = ROOT_PATH . "/assets/UPLOAD/" . $nomeImagem;

    if (!move_uploaded_file($arquivo['tmp_name'], $caminho)) {
        $_SESSION['mensagemPerfil'] = "Erro ao enviar a imagem.";
        header("Location: perfilUsuario.php");
        exit;
    }
}

  if ($novoNome === '' || $novoemail === '') {
    $_SESSION['mensagemPerfil'] = "Nome e email são obrigatórios.";
    header("Location: perfilUsuario.php");
    exit;
  }

  $sqlUpd = "UPDATE usuario SET nomeUsuario = ?, emailUsuario = ?, imgUsuario = ? WHERE idUsuario = ?";

$stmtUpd = mysqli_prepare($conexao, $sqlUpd);

mysqli_stmt_bind_param(
    $stmtUpd,
    "sssi",
    $novoNome,
    $novoemail,
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
  <?php $titulo = "Meu Perfil";  
  require_once ROOT_PATH . '/includes/head.php'; ?>

  <body>
<?php require_once ROOT_PATH . '/includes/header.php';?>
    <main class="container mt-4">
      <h1 class="text-center mb-4">Meu Perfil</h1>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow p-3">
            <div class="text-center">
              <?php if (!empty($imgUsuario)): ?>
    <img
      src="<?php echo BASE_URL . 'assets/UPLOAD/' . htmlspecialchars($imgUsuario); ?>"
      alt="Foto do usuário"
      style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%;"
    />
    <p><strong>Foto Atual do Perfil</strong></p>

  <?php else: ?>
    <i class="bi bi-person-circle" style="font-size: 160px;"></i>
    
  <?php endif; ?>
            </div>

            <div class="">
              <?php if ($_SESSION['nivel'] == 1) { ?>
                <span class="badge bg-danger ms-2 mb-1">Perfil de Administrador</span>
              <?php } ?>
              <p class="mb-1"><strong>Nome:</strong> <?php echo htmlspecialchars($nomeUsuario); ?></p>
              <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($emailUsuario); ?></p>
            </div>
            </div>
        </div>

        <div class="col-md-8">
          <div class="card shadow p-4">
            <h2 class="mb-3">Editar Perfil</h2>

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
                <label for="emailUsuario" class="form-label">Email:</label>
                <input
                  type="text"
                  class="form-control"
                  id="emailUsuario"
                  name="emailUsuario"
                  value="<?php echo htmlspecialchars($emailUsuario); ?>"
                  required
                />
              </div>
              
            <div class="mb-3">
    <label for="imgUsuario" class="form-label">Foto do Perfil:</label>

    <input
        type="file"
        class="form-control"
        id="imgUsuario"
        name="imgUsuario"
        accept="image/*"
        data-recortar>
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

    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
  </body>
</html>