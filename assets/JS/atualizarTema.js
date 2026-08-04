document.addEventListener("DOMContentLoaded", () => {
  const botaoTema = document.getElementById("btnTema");
  const iconeTema = document.getElementById("iconeTema");
  const imagemSacola = document.getElementById("sacola");

  const IMG_CLARO = BASE_URL + "assets/IMG/Sacola.png";
  const IMG_ESCURO = BASE_URL + "assets/IMG/SacolaDark.png";

  function aplicarTema(temaEscuro) {
    document.documentElement.setAttribute(
      "data-bs-theme",
      temaEscuro ? "dark" : "light",
    );
    document.body.classList.toggle("dark-mode", temaEscuro);

    if (iconeTema) {
      iconeTema.textContent = temaEscuro ? "light_mode" : "dark_mode";
    }

    if (imagemSacola) {
      imagemSacola.src = temaEscuro ? IMG_ESCURO : IMG_CLARO;
    }

    localStorage.setItem("tema", temaEscuro ? "escuro" : "claro");
  }

  const temaSalvo = localStorage.getItem("tema") === "escuro";
  aplicarTema(temaSalvo);

  botaoTema.addEventListener("click", () => {
    const estaEscuroAgora = localStorage.getItem("tema") === "escuro";
    aplicarTema(!estaEscuroAgora);
  });
});
