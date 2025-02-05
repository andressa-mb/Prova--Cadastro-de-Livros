document.addEventListener("DOMContentLoaded", function () {
    const btnsExcluir = document.querySelectorAll("a[data-toggle='modal']");
    btnsExcluir.forEach((btn) => {
        btn.addEventListener("click", function (event) {
            const id = this.getAttribute("data-id");
            const nome = this.getAttribute("data-nome");
            let route = this.getAttribute("data-route");
            let titulo = document.getElementById("titulo");
            titulo.textContent = `${nome} do id ${id}`;
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
