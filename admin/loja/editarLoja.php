<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idLoja = $_GET['id'] ?? null;

$sql = "SELECT * FROM loja WHERE idLoja = $idLoja";

$resultado = mysqli_query($conexao, $sql);

$dadosLoja = mysqli_fetch_assoc($resultado);
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Loja</title>
  </head>
  <body>
    <h1>Editar Loja</h1>
    <form action="atualizarLoja.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="idLoja" name="idLoja" value="<?php echo $dadosLoja['idLoja']; ?>" />

      <label for="nomeLoja">Nome:</label>
      <input type="text" id="nomeLoja" name="nomeLoja" value="<?php echo $dadosLoja['nomeLoja']; ?>" required />
      <br /><br>

      <label for="logoLoja">Logo atual:</label><br>

      <img
        src="../../assets/UPLOAD/<?php echo htmlspecialchars($dadosLoja['logoLoja']); ?>"
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