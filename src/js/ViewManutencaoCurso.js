document.getElementById("imagem")?.addEventListener("change", function () {
  const input = this;
  const erro = document.getElementById("imagem-erro");
  if (input.files.length > 0) {
    const file = input.files[0];
    const ext = file.name.split(".").pop().toLowerCase();
    if (ext !== "jpg" && ext !== "png") {
      erro.style.display = "block";
      input.value = "";
    } else {
      erro.style.display = "none";
    }
  }
});
