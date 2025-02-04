document.getElementById("addNovo").addEventListener("click", function () {
    const divLinks = document.getElementById("divLinks");
    const divGrupo = document.createElement("div");
    divGrupo.classList.add("row", "align-items-center", "mb-2");

    const divNome = document.createElement("div");
    divNome.classList.add("col-md-5");
    const labelNome = document.createElement("label");
    labelNome.textContent = "Nome do Site";
    labelNome.classList.add("form-label");
    const inputNome = document.createElement("input");
    inputNome.type = "text";
    inputNome.name = "site_nome[]";
    inputNome.classList.add("form-control");
    inputNome.id = "inputSite";

    divNome.appendChild(labelNome);
    divNome.appendChild(inputNome);

    const divUrl = document.createElement("div");
    divUrl.classList.add("col-md-5");
    const labelUrl = document.createElement("label");
    labelUrl.textContent = "URL do site";
    labelUrl.classList.add("form-label");
    const inputUrl = document.createElement("input");
    inputUrl.type = "text";
    inputUrl.name = "site_link[]";
    inputUrl.classList.add("form-control");
    inputUrl.id = "inputUrl";

    divUrl.appendChild(labelUrl);
    divUrl.appendChild(inputUrl);

    divBtn = document.createElement("div");
    divBtn.classList.add("col-md-2", "d-flex", "align-items-end");
    const btnRemover = document.createElement("button");
    btnRemover.textContent = "X";
    btnRemover.type = "button";
    btnRemover.classList.add("btn", "btn-danger", "ml-2");

    btnRemover.addEventListener("click", function () {
        divGrupo.remove();
    });

    divBtn.appendChild(btnRemover);
    divGrupo.appendChild(divNome);
    divGrupo.appendChild(divUrl);
    divGrupo.appendChild(divBtn);
    divLinks.appendChild(divGrupo);
});

document
    .querySelectorAll(
        ".form-group input[name='site_nome[]'], .form-group input[name='site_link[]']"
    )
    .forEach((input) => {
        input.addEventListener("input", function () {
            if (this.value.trim() === "") {
                this.value = null;
            }
        });
    });

document.querySelectorAll(".btn-remove").forEach(function (btn) {
    btn.addEventListener("click", function () {
        let siteGroup = this.closest(".form-row");
        let siteIdInput = siteGroup.querySelector('input[name="site_id[]"]');
        if (siteIdInput) {
            let siteId = siteIdInput.value;
            let removidosInput = document.getElementById("removidos");
            let removidos = removidosInput.value
                ? removidosInput.value.split(",")
                : [];
            removidos.push(siteId);
            removidosInput.value = removidos.join(",");
        }

        let nomeDoSite = siteGroup
            .querySelector('input[name="site_nome[]"]')
            .closest(".form-group");
        if (nomeDoSite) nomeDoSite.remove();

        let urlDoSite = siteGroup
            .querySelector('input[name="site_link[]"]')
            .closest(".form-group");
        if (urlDoSite) urlDoSite.remove();

        this.closest(".form-group").remove();
    });
});

document.getElementById("formEdit").addEventListener("submit", function (e) {
    e.preventDefault();

    let nome = document.getElementById("inputNome").value.trim();
    let bio = document.getElementById("inputBio").value.trim();
    let siteNameInput = document.getElementById("inputSite");
    let siteLinkInput = document.getElementById("inputUrl");
    let siteName = siteNameInput ? siteNameInput.value.trim() : "";
    let siteLink = siteLinkInput ? siteLinkInput.value.trim() : "";
    //    let removidosInput = document.getElementById("removidos");
    //    let removidos = removidosInput.value.trim();
    let errors = [];

    if (nome.length < 3) {
        errors.push("O nome do autor deve ter pelo menos 3 caracteres.");
    }

    if (bio.length > 300) {
        errors.push("A biografia deve ter no máximo 300 caracteres.");
    }

    document
        .querySelectorAll(
            'input[name="site_nome[]"], input[name="site_link[]"]'
        )
        .forEach((input) => {
            if (!input.value.trim()) {
                input.remove();
            }
        });

    document.querySelectorAll('input[name="site_link[]"]').forEach((input) => {
        let urlCorrigida = verificarEAdicionarProtocolo(input.value.trim());
        if (urlCorrigida) {
            input.value = urlCorrigida;
        } else {
            errors.push(`O link "${input.value}" não é válido.`);
        }
    });

    if (siteName && siteLink) {
        let urlCorrigida = verificarEAdicionarProtocolo(siteLink);
        if (urlCorrigida) {
            document.getElementById("inputUrl").value = urlCorrigida;
        } else {
            errors.push(`Digite um link válido.`);
        }
    }
    /* 
    if (removidos !== "") {
        // Envia o formulário
        this.submit();
    } else {
        alert("Não há links para remover.");
    } */

    if (errors.length > 0) {
        return alert(errors.join("\n"));
    }

    this.submit();
});

function verificarEAdicionarProtocolo(url) {
    if (!url.match(/^https?:\/\//i)) {
        url = "http://" + url;
    }

    const dominioValido = /^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,6}(\/.*)?$/i;

    if (dominioValido.test(url)) {
        try {
            new URL(url);
            return url;
        } catch (e) {
            return false;
        }
    } else {
        return false;
    }
}
