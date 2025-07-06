document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".btn-excluir-video").forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      if (!confirm("Tem certeza que deseja excluir este vídeo?")) {
        e.preventDefault();
      }
    });
  });
});
