<?php
// Garante sessão ativa e as constantes ROOT_PATH / BASE_URL disponíveis
require_once __DIR__ . '/config.php';

/**
 * Bloqueia o acesso de quem não está logado.
 * Chame no topo de QUALQUER página administrativa (listar, inserir,
 * editar, excluir) antes de qualquer outra coisa.
 */
function exigirLogin(): void
{
    if (!isset($_SESSION['idUsuario'])) {
        header("Location: " . BASE_URL . "admin/usuario/loginUsuario.php");
        exit;
    }
}
