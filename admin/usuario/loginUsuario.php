<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
  try{
    $emailUsuario = trim($_POST['emailUsuario'] ?? '');
    $senhaUsuario = trim($_POST['senhaUsuario'] ?? '');

    if ($emailUsuario === '' || $senhaUsuario === '') {
    throw new Exception("Preencha todos os campos.");
}

    // CORRIGIDO: Uso de Prepared Statement contra SQL Injection
    $sql = "SELECT * FROM usuario WHERE emailUsuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $emailUsuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (!$resultado) {
        die(mysqli_error($conexao));
    }

    if(mysqli_num_rows($resultado)>0){
        $dados = mysqli_fetch_assoc($resultado);

        if(password_verify($senhaUsuario, $dados['senhaUsuario'])){
            $_SESSION['idUsuario']= $dados['idUsuario'];
            $_SESSION['nomeUsuario']= $dados['nomeUsuario'];
            $_SESSION['emailUsuario']= $dados['emailUsuario'];

            mysqli_stmt_close($stmt);

            header("Location: " . BASE_URL . "index.php");
            exit;
        } else {
            throw new Exception("E-mail ou senha inválidos.");
        }
    } else {
        throw new Exception("E-mail ou senha inválidos.");
    }
  } catch(Exception $e){
    $_SESSION['mensagem'] = "Erro ao realizar login: " . $e->getMessage();
    $_SESSION['tipoMensagem'] = "danger";
    header("Location: loginUsuario.php");
    exit;
  }
  mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<?php $titulo = "Top Achados - Login";
require_once ROOT_PATH . '/includes/head.php'; ?>

<body>
  <main>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>

        <!-- Modal -->
<div class="modal fade" id="modalMensagem" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <?php
                $tipo = $_SESSION['tipoMensagem'] ?? 'primary';

                switch ($tipo) {
                    case 'success':
                        $cor = 'bg-success';
                        $titulo = 'Sucesso';
                        break;

                    case 'warning':
                        $cor = 'bg-warning';
                        $titulo = 'Aviso';
                        break;

                    case 'danger':
                        $cor = 'bg-danger';
                        $titulo = 'Erro';
                        break;

                    default:
                        $cor = 'bg-primary';
                        $titulo = 'Mensagem';
                }
            ?>

            <div class="modal-header <?= $cor ?> text-white">
                <h5 class="modal-title"><?= $titulo ?></h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <?= $_SESSION['mensagem'] ?? '' ?>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-primary"
                    data-bs-dismiss="modal">

                    OK

                </button>

            </div>

        </div>
    </div>
</div>
<!-- Fim Modal -->

    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

          <h1 class="text-center mb-5">
            Login de Usuário
          </h1>

          <form action="loginUsuario.php" method="post">

            <div class="mb-3">
              <label class="form-label" for="emailUsuario">E-mail:</label>
              <input
                class="form-control"
                type="email"
                id="emailUsuario"
                name="emailUsuario"
                required
              />
            </div>

            <div class="mb-3">
              <label class="form-label" for="senhaUsuario">Senha:</label>
              <input
                class="form-control"
                type="password"
                id="senhaUsuario"
                name="senhaUsuario"
                required
              />

              <div class="mb-3">
                <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
                <label class="form-check-label"for="checkDefault">
                  Mostrar senha
                </label>
              </div>

            </div>
            

            <!-- Link de cadastro -->
            <div class="text-center mb-4">
              <span class="text-secondary">Não possui cadastro?</span>
              <a href="<?= BASE_URL ?>admin/usuario/inserirUsuarioForm.php"
                 class="text-decoration-none fw-semibold">
                Cadastre-se
              </a>
            </div>

            <div class="text-center">
              <button
                type="submit"
                class="btn btn-primary rounded-pill px-5 py-2"
                style="min-width:200px;">
                Fazer login
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>
</main>

    <?php require_once ROOT_PATH . '/includes/footer.php';?>


  <!-- <form action="" method="post">
          <label for="loginUsuario">Usuario:</label>
          <input
            type="text"
            
            id="loginUsuario"
            name="loginUsuario"
            
          />
          <br /><br />
          <label for="senhaUsuario">Senha:</label>
          <input
            type="password"
            
            id="senhaUsuario"
            name="senhaUsuario"
            
          />
          <span id="erroSenha" ></span>
           <div >
              <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
              <label class="form-check-label" for="checkDefault">
                Mostrar senha
              </label>
            </div>
            <button type="submit" value="login" >
              Login
            </button> -->
           
           <script src="<?= BASE_URL ?>assets/JS/InserirFoto.js"></script>
           <script src="<?= BASE_URL ?>assets/JS/validacoes.js"></script>
<?php if (isset($_SESSION['mensagem'])): ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const modal = new bootstrap.Modal(document.getElementById("modalMensagem"));
    modal.show();
});
</script>

<?php
unset($_SESSION['mensagem']);
unset($_SESSION['tipoMensagem']);
endif;
?> 
</body>
</html>