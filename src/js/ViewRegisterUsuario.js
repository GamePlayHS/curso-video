document.addEventListener("DOMContentLoaded", function () {
  // Mostrar/ocultar senha
  document.getElementById("toggleSenha").addEventListener("click", function () {
    const senhaInput = document.getElementById("senha");
    const icon = document.getElementById("iconSenha");
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

  document
    .getElementById("toggleConfirmarSenha")
    .addEventListener("click", function () {
      const senhaInput = document.getElementById("confirmar_senha");
      const icon = document.getElementById("iconConfirmarSenha");
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

  // Mensagem de erro dinâmica para confirmação de senha
  const confirmarSenhaInput = document.getElementById("confirmar_senha");
  const senhaInput = document.getElementById("senha");

  // Cria o elemento de feedback abaixo do campo de confirmação de senha, se não existir
  let feedback = document.getElementById("feedback-confirmar-senha");
  if (!feedback) {
    feedback = document.createElement("div");
    feedback.id = "feedback-confirmar-senha";
    feedback.className = "form-text text-danger";
    // Insere logo após o campo de confirmação de senha
    confirmarSenhaInput.parentNode.parentNode.appendChild(feedback);
  }

  // Cria o elemento de feedback para senha forte, se não existir
  let feedbackSenha = document.getElementById("feedback-senha-forte");
  if (!feedbackSenha) {
    feedbackSenha = document.createElement("div");
    feedbackSenha.id = "feedback-senha-forte";
    feedbackSenha.className = "form-text text-danger";
    // Insere logo após o campo de senha
    senhaInput.parentNode.parentNode.appendChild(feedbackSenha);
  }

  function senhaForte(senha) {
    // Mínimo 8 caracteres, pelo menos uma letra, um número e um caractere especial
    return /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/.test(senha);
  }

  function validarSenhas() {
    // Validação senha forte
    if (senhaInput.value && !senhaForte(senhaInput.value)) {
      feedbackSenha.textContent = "A senha deve ter no mínimo 8 caracteres, incluindo letra, número e caractere especial.";
    } else {
      feedbackSenha.textContent = "";
    }

    // Validação confirmação de senha
    if (confirmarSenhaInput.value && confirmarSenhaInput.value !== senhaInput.value) {
      feedback.textContent = "As senhas não conferem!";
    } else {
      feedback.textContent = "";
    }
  }

  confirmarSenhaInput.addEventListener("input", validarSenhas);
  senhaInput.addEventListener("input", validarSenhas);

  // Validação final no submit
  document
    .getElementById("formCadastro")
    .addEventListener("submit", function (oSubmit) {
      let erro = false;
      if (!senhaForte(senhaInput.value)) {
        feedbackSenha.textContent = "A senha deve ter no mínimo 8 caracteres, incluindo letra, número e caractere especial.";
        senhaInput.focus();
        erro = true;
      }
      if (confirmarSenhaInput.value !== senhaInput.value) {
        feedback.textContent = "As senhas não conferem!";
        confirmarSenhaInput.focus();
        erro = true;
      }
      if (erro) oSubmit.preventDefault();
    });
});
