/**
 * Recorte de imagem antes do upload — funciona em qualquer <input
 * type="file"> do site.
 *
 * Como usar: adicione o atributo data-recortar no input de arquivo.
 *   <input type="file" name="foto" accept="image/*" data-recortar>
 *
 * Ao escolher uma imagem, abre um modal pra recortar (Cropper.js). Ao
 * confirmar, o arquivo original do input é substituído pelo recorte —
 * o formulário envia a imagem já recortada, sem precisar mudar nada
 * no PHP que processa o upload.
 *
 * Se o input tiver um data-preview="idDoElemento", a <img> com esse
 * id é atualizada com o resultado do recorte (preview em tempo real).
 */
document.addEventListener("DOMContentLoaded", function () {
  const modalElemento = document.getElementById("modalRecortarImagem");
  if (!modalElemento || typeof bootstrap === "undefined" || typeof Cropper === "undefined") {
    return;
  }

  const modal = new bootstrap.Modal(modalElemento);
  const imagemParaRecortar = document.getElementById("imagemParaRecortar");
  const btnConfirmarRecorte = document.getElementById("btnConfirmarRecorte");

  let cropper = null;
  let inputAtual = null;

  document.querySelectorAll('input[type="file"][data-recortar]').forEach(function (input) {
    input.addEventListener("change", function (evento) {
      const arquivo = evento.target.files && evento.target.files[0];
      if (!arquivo || arquivo.type.indexOf("image/") !== 0) {
        return;
      }

      inputAtual = input;

      const leitor = new FileReader();
      leitor.onload = function (eventoLeitura) {
        imagemParaRecortar.src = eventoLeitura.target.result;
        modal.show();
      };
      leitor.readAsDataURL(arquivo);
    });
  });

  modalElemento.addEventListener("shown.bs.modal", function () {
    if (cropper) {
      cropper.destroy();
    }
    cropper = new Cropper(imagemParaRecortar, {
      viewMode: 1,
      autoCropArea: 1,
      background: false,
    });
  });

  modalElemento.addEventListener("hidden.bs.modal", function () {
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
    // Se o usuário cancelou sem confirmar, limpa o input pra não
    // ficar um arquivo "pela metade" selecionado.
    if (inputAtual && !inputAtual.dataset.recorteConfirmado) {
      inputAtual.value = "";
    }
    if (inputAtual) {
      delete inputAtual.dataset.recorteConfirmado;
    }
  });

  btnConfirmarRecorte.addEventListener("click", function () {
    if (!cropper || !inputAtual) {
      return;
    }

    const arquivoOriginal = inputAtual.files[0];
    const tipoSaida = arquivoOriginal.type === "image/png" ? "image/png" : "image/jpeg";

    cropper.getCroppedCanvas().toBlob(function (blob) {
      if (!blob) {
        return;
      }

      const arquivoRecortado = new File([blob], arquivoOriginal.name, { type: tipoSaida });
      const transferenciaArquivo = new DataTransfer();
      transferenciaArquivo.items.add(arquivoRecortado);
      inputAtual.files = transferenciaArquivo.files;

      const idPreview = inputAtual.getAttribute("data-preview");
      if (idPreview) {
        const elementoPreview = document.getElementById(idPreview);
        if (elementoPreview) {
          elementoPreview.src = URL.createObjectURL(blob);
        }
      }

      inputAtual.dataset.recorteConfirmado = "1";
      modal.hide();
    }, tipoSaida, 0.9);
  });
});
