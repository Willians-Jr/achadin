<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

// 1. Pega o ID da URL. Se não existir, define como null
$idLoja = $_GET['id'] ?? null;

// Inicializa a variável para evitar erros na exibição do HTML depois
$dadosLoja = null;

// 2. Só executa o banco se um ID válido foi enviado
if ($idLoja) {
    $sql = "SELECT * FROM loja WHERE idLoja = ?";

    if ($stmt = mysqli_prepare($conexao, $sql)) {
        
        // Vincula o parâmetro. O "i" significa que o ID deve ser tratado estritamente como Inteiro (Integer)
        mysqli_stmt_bind_param($stmt, "i", $idLoja);
        
        // Executa a consulta com segurança
        mysqli_stmt_execute($stmt);
        
        // Pega o resultado
        $resultado = mysqli_stmt_get_result($stmt);
        
        // Guarda os dados da loja
        $dadosLoja = mysqli_fetch_assoc($resultado);
    }
}

// 3. Se a loja não for encontrada ou o ID não for enviado, você pode tratar aqui
if (!$dadosLoja) {
    echo "Loja não encontrada.";
}
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lojas - Editar</title>
  </head>
  <body>
    <h1>Formulário de Edição de Loja</h1>
    <form action="atualizarLoja.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="idLoja" name="idLoja" value="<?php echo $dadosLoja['idLoja']; ?>" />

      <label for="nomeLoja">Nome:</label>
      <input type="text" id="nomeLoja" name="nomeLoja" value="<?php echo $dadosLoja['nomeLoja']; ?>" required />
      <br /><br>

      <label for="linkLoja">Link da Loja</label>
      <input type="text" name="linkLoja" id="linkLoja" value="<?php echo $dadosLoja['linkLoja'];?>">
      <br><br>

      <label for="logoLoja">Logo atual:</label><br>

      <img
        src="<?= BASE_URL ?>/assets/UPLOAD/<?php echo htmlspecialchars($dadosLoja['logoLoja']); ?>"
        alt="Logo da Loja"
        width="100">
       <br><br>

      <label for="logoLoja">Nova logo (opcional):</label>
      <input type="file" id="logoLoja" name="logoLoja" accept="image/*">
      <br><br>

      <input
        type="hidden"
        name="logoAtual"
        value="<?php echo htmlspecialchars($dadosLoja['logoLoja']); ?>">

      <button type="submit">Atualizar Loja</button>
    </form>
  </body>
</html>