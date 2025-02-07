/* document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formCadastroCategorias");
    if (form) {
        form.addEventListener("submit", function (e) {
            let nome = document.getElementById("inputNomeCat").value.trim();
            let descricao = document
                .getElementById("inputDescricao")
                .value.trim();
            let errors = [];
            if (nome.length < 3) {
                errors.push(
                    "O nome da categoria deve ter pelo menos 3 caracteres."
                );
            }
            if (descricao.length > 100) {
                errors.push(
                    "O nome da descrição deve ter no máximo 100 caracteres."
                );
            }
            if (errors.length > 0) {
                e.preventDefault();
                alert(errors.join("\n"));
            }
        });
    }
});
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("carregou a pagina delete");
    const btnsExcluir = document.querySelectorAll("a[data-toggle='modal']");
    btnsExcluir.forEach((btn) => {
        btn.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const nome = this.getAttribute("data-nome");
            const route = this.getAttribute("data-route");
            const nomeCat = document.getElementById("nomeCat");
            nomeCat.textContent = `${nome} do id ${id}`;
            document
                .getElementById("formExcluir")
                .setAttribute("action", route);
        });
    });

    const confirmarExcluir = document.getElementById("confirmeExcluir");
    if (confirmarExcluir) {
        confirmarExcluir.addEventListener("click", function () {
            document.getElementById("formExcluir").submit();
        });
    }
});
