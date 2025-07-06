document.addEventListener("DOMContentLoaded", function () {
  const tipoVideo = document.getElementById("tipo_video");
  const campoArquivo = document.getElementById("campo-arquivo");
  const campoUrl = document.getElementById("campo-url");

  function toggleCampos() {
    if (tipoVideo.value === "arquivo") {
      campoArquivo.classList.remove("d-none");
      campoArquivo.querySelector("input").required = true;
      campoUrl.classList.add("d-none");
      campoUrl.querySelector("input").required = false;
    } else {
      campoArquivo.classList.add("d-none");
      campoArquivo.querySelector("input").required = false;
      campoUrl.classList.remove("d-none");
      campoUrl.querySelector("input").required = true;
    }
  }

  tipoVideo.addEventListener("change", toggleCampos);
  toggleCampos();
});
