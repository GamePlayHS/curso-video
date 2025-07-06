debugger;
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("imagem");

    input.addEventListener("change", function () {
        debugger;
        const file = input.files[0];

        if (file) {
            const extensao = file.name.split('.').pop().toLowerCase();
            if (extensao !== "png" && extensao !== "jpg") {
                alert("Formato inválido! Apenas arquivos .png e .jpg são permitidos.");
                input.value = ""; // Limpa o campo de upload
            }
        }
    });
});