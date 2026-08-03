<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
define('ROOT_PATH', dirname(__DIR__));
define('BASE_URL', '/TopAchados/');
function exigirLogin(): void
{
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: " . BASE_URL . "admin/usuario/loginUsuario.php");
        exit;
    }
}
?>