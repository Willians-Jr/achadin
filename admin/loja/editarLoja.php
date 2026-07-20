<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idLoja = $_GET['idLoja'];

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
    <form action="atualizarLoja.php" method="POST">
      <input type="hidden" id="idLoja" name="idLoja" value="<?php echo $dadosLoja['idLoja']; ?>" />

      <label for="nomeLoja">Nome:</label>
      <input type="text" id="nomeLoja" name="nomeLoja" value="<?php echo $dadosLoja['nomeLoja']; ?>" required />
      <br />

      <label for="logoLoja">Logo:</label>
      <!-- Requer atenção -->
      <input type="file" id="logoLoja" name="logoLoja" value="<?php echo $dadosLoja['']; ?>" required />
      <br />

      <button type="submit">Atualizar Loja</button>
    </form>
  </body>
</html>