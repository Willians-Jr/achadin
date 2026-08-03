 <?php

require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Acesso negado: Este arquivo deve ser chamado via formulário.");
}

if (!isset($_POST['nomeUsuario'], $_POST['senhaUsuario'], $_POST['emailUsuario'])) {
    die("Erro: Todos os campos são obrigatórios.");
}

$nomeUsuario  = trim($_POST['nomeUsuario']);
$emailUsuario = trim($_POST['emailUsuario']);
$senhaUsuario = $_POST['senhaUsuario'];

// Validação básica de campos vazios
if (empty($nomeUsuario) || empty($senhaUsuario) || empty($emailUsuario)) {
    die("Erro: Todos os campos são obrigatórios.");
}

// Validação de e-mail
if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
    die("E-mail inválido.");
}

// Validação de senha forte (única fonte de verdade — não confiamos no hidden input do form)
if (
    strlen($senhaUsuario) < 6 ||
    !preg_match('/[A-Z]/', $senhaUsuario) ||
    !preg_match('/[a-z]/', $senhaUsuario) ||
    !preg_match('/[0-9]/', $senhaUsuario) ||
    !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senhaUsuario)
) {
    die("Cadastre uma senha forte!");
}

// Verifica se o e-mail já está cadastrado
$sqlCheck = "SELECT idUsuario FROM usuario WHERE emailUsuario = ?";
$stmtCheck = mysqli_prepare($conexao, $sqlCheck);
mysqli_stmt_bind_param($stmtCheck, "s", $emailUsuario);
mysqli_stmt_execute($stmtCheck);
mysqli_stmt_store_result($stmtCheck);

if (mysqli_stmt_num_rows($stmtCheck) > 0) {
    mysqli_stmt_close($stmtCheck);
    die("Este e-mail já está cadastrado.");
}
mysqli_stmt_close($stmtCheck);

$senhacripto = password_hash($senhaUsuario, PASSWORD_DEFAULT);

// Upload de imagem — só acontece depois de TODAS as validações de dados passarem
$nomeImagem = "";

if (isset($_FILES["imgUsuario"]) && $_FILES["imgUsuario"]["error"] == UPLOAD_ERR_OK) {

    $imagem = $_FILES["imgUsuario"];

    // Limite de tamanho (2MB, por exemplo)
    $tamanhoMaximo = 2 * 1024 * 1024;
    if ($imagem['size'] > $tamanhoMaximo) {
        die("Imagem muito grande. Máximo de 2MB.");
    }

    // Verifica o tipo REAL do arquivo (não confia no header enviado pelo navegador)
    $mimesPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeReal = finfo_file($finfo, $imagem['tmp_name']);
    finfo_close($finfo);

    if (!array_key_exists($mimeReal, $mimesPermitidos)) {
        die("Formato de imagem inválido.");
    }

    // Extensão derivada do MIME real verificado, não do nome enviado pelo usuário
    $extensao = $mimesPermitidos[$mimeReal];
    $nomeImagem = uniqid() . "." . $extensao;
    $caminho = ROOT_PATH . "/assets/UPLOAD/" . $nomeImagem;

    if (!move_uploaded_file($imagem['tmp_name'], $caminho)) {
        die("Erro ao enviar a imagem.");
    }
}

// Insere no banco
$sql = "INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario, imgUsuario) VALUES (?, ?, ?, ?)";
$resultado = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($resultado, "ssss", $nomeUsuario, $emailUsuario, $senhacripto, $nomeImagem);

if (mysqli_stmt_execute($resultado)) {
    mysqli_stmt_close($resultado);
    mysqli_close($conexao);
    header("Location: loginUsuario.php");
    exit; // ESSENCIAL — sem isso o script continua rodando após o redirect
} else {
    // Loga o erro real internamente, mostra mensagem genérica pro usuário
    error_log("Erro ao inserir usuário: " . mysqli_error($conexao));
    die("Erro ao cadastrar usuário. Tente novamente mais tarde.");
}