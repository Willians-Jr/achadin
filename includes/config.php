<?php
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'] ?? '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', '/topachados/');
function exigirLogin(): void
{
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: " . BASE_URL . "admin/usuario/loginUsuario.php");
        exit;
    }
}

/**
 * Verifica se o usuário logado é administrador (nivel = 1), consultando
 * direto no banco em vez de confiar em $_SESSION['nivel'] (que só é
 * preenchido por includes/header.php).
 * Chamar sempre DEPOIS de exigirLogin() e de includes/conexao.php.
 */
function usuarioEhAdmin(): bool
{
    global $conexao;

    $idUsuario = $_SESSION['idUsuario'] ?? 0;
    $nivel = 0;

    if ($conexao && $idUsuario) {
        $stmt = mysqli_prepare($conexao, "SELECT nivel FROM usuario WHERE idUsuario = ?");
        mysqli_stmt_bind_param($stmt, "i", $idUsuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        if ($linha = mysqli_fetch_assoc($resultado)) {
            $nivel = (int) $linha['nivel'];
        }
        mysqli_stmt_close($stmt);
    }

    return $nivel === 1;
}

/**
 * Garante que o usuário logado é administrador (nivel = 1).
 * Chamar sempre DEPOIS de exigirLogin() e de includes/conexao.php.
 */
function exigirAdmin(): void
{
    if (!usuarioEhAdmin()) {
        header("Location: " . BASE_URL . "admin/usuario/logadoUsuario.php");
        exit;
    }
}

/**
 * Garante que o usuário logado é o dono do registro (comparando $idDono
 * com o idUsuario da sessão) OU é administrador. Use para proteger ações
 * sobre um registro específico (ex.: editar/excluir um produto) quando
 * usuários comuns podem mexer só no que é deles, mas admins podem mexer
 * em tudo. Chamar sempre DEPOIS de exigirLogin().
 */
function exigirDonoOuAdmin(int $idDono): void
{
    $idUsuario = (int) ($_SESSION['idUsuario'] ?? 0);

    if ($idDono === $idUsuario) {
        return;
    }

    if (!usuarioEhAdmin()) {
        header("Location: " . BASE_URL . "admin/usuario/logadoUsuario.php");
        exit;
    }
}
?>