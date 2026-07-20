function verificarSenha() {
  // Procura primeiro senhaNova, se não existir usa senhaUsuario
  const campoSenha =
    document.getElementById("senhaNova") ||
    document.getElementById("senhaUsuario");

  const senha = campoSenha.value;

  const erroSenha = document.getElementById("erroSenha");
  const senhaForte = document.getElementById("senhaForte");

  let numero = /[0-9]/;
  let letraMaiuscula = /[A-Z]/;
  let letraMinuscula = /[a-z]/;
  let caractere = /[!@#$%^&*(),.?":{}|<>]/;

  let pontos = 0;

  if (numero.test(senha)) pontos++;
  if (letraMaiuscula.test(senha)) pontos++;
  if (letraMinuscula.test(senha)) pontos++;
  if (caractere.test(senha)) pontos++;

  if (senha == "") {
    erroSenha.textContent = "";
    return;
  }

  if (senha.length < 6) {
    erroSenha.textContent = "A senha deve ter no mínimo 6 caracteres";
    erroSenha.style.color = "red";
    senhaForte.value = "false";
  } else if (pontos == 4) {
    erroSenha.textContent = "Senha forte";
    erroSenha.style.color = "green";
    senhaForte.value = "true";
  } else if (pontos >= 3) {
    erroSenha.textContent = "Senha média";
    erroSenha.style.color = "orange";
    senhaForte.value = "false";
  } else {
    erroSenha.textContent = "Senha muito fraca";
    erroSenha.style.color = "red";
    senhaForte.value = "false";
  }
}

function mostrarSenha() {
  // Procura primeiro senhaNova, se não existir usa senhaUsuario
  const campoSenha =
    document.getElementById("senhaNova") ||
    document.getElementById("senhaUsuario");

  campoSenha.type = campoSenha.type === "password" ? "text" : "password";
}
