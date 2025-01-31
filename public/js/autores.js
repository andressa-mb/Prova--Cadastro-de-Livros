document.getElementById("addLinkBtn").addEventListener("click", function () {
    var siteName = document.getElementById("inputSite").value.trim();
    var siteLink = document.getElementById("inputUrl").value.trim();

    if (siteName && siteLink) {
        if (verificarEAdicionarProtocolo(siteLink)) {
            var addedLinksDiv = document.getElementById("addedLinks");
            var linkItem = document.createElement("div");
            linkItem.classList.add("link_item");
            linkItem.innerHTML = `
                <span class="ml-4" >${siteName} - <a href="${siteLink}" target="_blank">${siteLink}</a></span>
                <button type="button" class="btn btn-danger btn-sm remove-link">X</button>
                <input type="hidden" name="site_nome[]" value="${siteName}">
                <input type="hidden" name="site_link[]" value="${siteLink}">
            `;

            addedLinksDiv.appendChild(linkItem);

            document.getElementById("inputSite").value = "";
            document.getElementById("inputUrl").value = "";
        } else {
            alert(
                "URL inválida! Certifique-se de que a URL tenha um domínio válido, como .com, .org, etc."
            );
        }
    } else {
        alert("Preencha o nome do site e a URL!");
    }
});

document.addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("remove-link")) {
        e.target.parentNode.remove();
    }
});

function verificarEAdicionarProtocolo(url) {
    if (!url.match(/^https?:\/\//i)) {
        url = "http://" + url;
    }

    const dominioValido = /^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,6}(\/.*)?$/i;

    if (dominioValido.test(url)) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    } else {
        return false;
    }
}

document
    .getElementById("formCadastro")
    .addEventListener("submit", function (e) {
        document
            .querySelectorAll(
                'input[name="site_nome[]"], input[name="site_link[]"]'
            )
            .forEach((input) => {
                if (!input.value.trim()) {
                    input.remove();
                }
            });

        let nome = document.getElementById("inputAutor").value.trim();
        let bio = document.getElementById("inputBio").value.trim();
        let errors = [];

        if (nome.length < 3) {
            errors.push("O nome do autor deve ter pelo menos 3 caracteres.");
        }

        if (bio.length > 300) {
            errors.push("A biografia deve ter no máximo 300 caracteres.");
        }

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join("\n"));
        }
    });
