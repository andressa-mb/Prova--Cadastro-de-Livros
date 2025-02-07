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
