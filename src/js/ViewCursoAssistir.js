document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById("formQuestionario");
    if (form) {
        form.addEventListener("submit", function (e) {
            debugger;
            e.preventDefault();
            var selecionado = form.querySelector('input[name="resposta"]:checked');
            if (!selecionado) {
                var modal = new bootstrap.Modal(
                    document.getElementById("modalErroResposta")
                );
                modal.show();
                return;
            }

            // Monta os dados para envio
            var formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
            })
                .then((response) => response.json())
                .then((data) => {
                    // Exibe modal de feedback
                    var modalMsg = document.getElementById("modalFeedbackRespostaMsg");
                    var modalTitle = document.getElementById(
                        "modalFeedbackRespostaLabel"
                    );
                    if (data.correta) {
                        modalTitle.textContent = "Parabéns!";
                        modalMsg.textContent = "Você acertou a resposta!";
                        modalMsg.className = "text-success";
                    } else {
                        modalTitle.textContent = "Que pena!";
                        modalMsg.textContent = "Você errou a resposta.";
                        modalMsg.className = "text-danger";
                    }
                    var modal = new bootstrap.Modal(
                        document.getElementById("modalFeedbackResposta")
                    );
                    modal.show();

                    // Opcional: bloquear alternativas após resposta
                    form
                        .querySelectorAll('input[name="resposta"]')
                        .forEach(function (el) {
                            el.disabled = true;
                        });
                    form.querySelector('button[type="submit"]').disabled = true;
                })
                .catch(() => {
                    alert("Erro ao enviar resposta. Tente novamente.");
                });
        });
    }
});
