document.addEventListener("DOMContentLoaded", main);

function main() {
    let root = window.location.href;

    let exoplanetForm = document.querySelector('#exoplanet-form');
    let starForm = document.querySelector('#star-form');

    let exoplanetRadio = document.querySelector('#toggle-exoplanets');
    let starRadio = document.querySelector('#toggle-stars');

    let selectMethodsContainer = document.querySelector('#select-methods-container');
    let selectStarsContainer = document.querySelector('#select-stars-container');

    let messageDiv = document.querySelector('#message');

    refreshSelects("methods");
    refreshSelects("stars");

    exoplanetForm.addEventListener('submit', (e) => {
        e.preventDefault();
        processForm(exoplanetForm)
    });

    starForm.addEventListener('submit', (e) => {
        e.preventDefault();
        processForm(starForm)
    });

    exoplanetRadio.addEventListener('click', () => {
        refreshSelects("methods");
        refreshSelects("stars");
        ocultarFormulario(exoplanetRadio.value);
    })

    starRadio.addEventListener('click', () => {
        ocultarFormulario(starRadio.value);
    })


    async function processForm(form) {
        let data = new FormData(form);
        let object;
        let type;
        if (exoplanetRadio.checked) {
            object = {
                "name": data.get("exoplanet-name").replace(/\//g, ""),
                "mass": data.get("exoplanet-mass"),
                "radius": data.get("exoplanet-radius"),
                "method": data.get("exoplanet-method"),
                "star": data.get("exoplanet-star"),
            }
            type = exoplanetRadio.value;
        }
        else {
            object = {
                "name": data.get("star-name"),
                "mass": data.get("star-mass"),
                "radius": data.get("star-radius"),
                "distance": data.get("star-distance"),
                "type": data.get("star-type"),
            }
            type = starRadio.value;
        }


        await sendDataAndRetrieveResponse(object, type);
    }

    async function sendDataAndRetrieveResponse(object, type) {
        try {
            let response = await fetch(`${root}/${type}`, {
                "method": "POST",
                "headers": { "Content-Type": "application/json" },
                "body": JSON.stringify(object),
            });

            messageDiv.classList.add('alert');
            messageDiv.classList.add(response.ok ? 'alert-success' : 'alert-warning');
            messageDiv.innerHTML = await response.text();
        }
        catch (exc) {
            console.log(exc);
        }
    }

    async function refreshSelects(type) {
        let select = await getSelect(type);
        if (type == 'methods') {
            selectMethodsContainer.innerHTML = select;
        }
        else if (type == 'stars') {
            selectStarsContainer.innerHTML = select;
        }
    }

    async function getSelect(type) {
        try {
            stringQuery = root.replace("add", `select/${type}${type === 'methods' ? "/long" : ""}`);
            let response = await fetch(stringQuery);
            let content = await response.text();
            return content;
        }
        catch (Exc) {
            console.log(Exc);
            messageDiv.innerHTML = '<div class="alert alert-warning">There was an error when communicating with the server</div>';
            return null;
        }
    }

    function ocultarFormulario(value) {
        if (value == 'exoplanets') {
            exoplanetForm.classList.remove('hidden');
            starForm.classList.add('hidden');
        }
        else if (value == 'stars') {
            exoplanetForm.classList.add('hidden');
            starForm.classList.remove('hidden');
        }
    }
}