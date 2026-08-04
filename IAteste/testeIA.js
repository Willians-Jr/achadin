document.getElementById("btnIA").addEventListener("click", async () => {
  try {
    const resposta = await fetch("buscarEspecialidadesIA.php");

    const dados = await resposta.json();

    if (dados.sucesso) {
      alert(
        "Novas especialidades: " +
          dados.novas +
          "\nJá existentes: " +
          dados.existentes,
      );

      location.reload();
    } else {
      alert(dados.erro);

      console.log(dados);
    }
  } catch (erro) {
    console.log(erro);

    alert("Erro ao conectar com a IA.");
  }
});
