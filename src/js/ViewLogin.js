document.addEventListener("DOMContentLoaded", function () {
  const btnToggle = document.getElementById("toggleSenha");
  const senhaInput = document.getElementById("senha");
  const icon = document.getElementById("iconSenha");
  btnToggle.addEventListener("click", function () {
    if (senhaInput.type === "password") {
      senhaInput.type = "text";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      senhaInput.type = "password";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  });
});
