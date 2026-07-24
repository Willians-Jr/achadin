<?php
    session_start();

    // destruir a sessão
    session_destroy();

    header("location: index.php");

?>