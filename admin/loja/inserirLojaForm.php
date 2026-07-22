<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
require_once ROOT_PATH . '/includes/header.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lojas - Cadastrar</title>
</head>
<body>
    

<h1>Formulário de Cadastro de Loja</h1>

<form action="inserirLoja.php" method="post" enctype="multipart/form-data">

    <label for="nomeLoja">Nome da Loja:</label>
    <input type="text" name="nomeLoja" id="nomeLoja" required>
    <br><br>

    <label for="logoLoja">Logo da Loja:</label>
    <input type="file" name="logoLoja" id="logoLoja" accept="image/*" required>
    <br><br>

    <button type="submit">Cadastrar Loja</button>

</form>
</body>
</html>