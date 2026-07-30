<?php
    require_once dirname(__DIR__, 2) . '/includes/config.php';

    // destruir a sessão
    session_destroy();

   header("Location: " . BASE_URL . "index.php");

?>