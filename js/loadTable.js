document.addEventListener('DOMContentLoaded', main);

function main() {
    let url = window.location.href;
    let exoplanetsBtn = document.querySelector('#exoplanets-btn');
    let starsBtn = document.querySelector('#stars-btn');
    let tableDiv = document.querySelector('#table');
    let editBtns = [];
    let deleteBtns = [];
    let messageDiv = document.querySelector('#message');

    exoplanetsBtn.addEventListener('click', (e) => {
        loadTable('exoplanets');
    })

    starsBtn.addEventListener('click', (e) => {
        loadTable('stars');
    })

    loadTable('exoplanets');

    //-----------------------------------------Table loading--------------------------------------------

    async function loadTable(type) {
        try {
            let response = await fetch(url.replace("tables", type))
            let content = await response.text();
            tableDiv.innerHTML = content;
            findButtons();
        }
        catch (error) {
            console.log(error);
        }
    }

    function findButtons() {
        editBtns = document.querySelectorAll('.edit-btn');
        deleteBtns = document.querySelectorAll('.delete-btn');
        editBtns.forEach((item) => {
            item.addEventListener('click', (e) => {
                if (e.target.value == "Edit") {
                    editItem(e.target);
                }
                else if (e.target.value == "Confirm") {
                    confirmEdition(e.target);
                }
            })
        });
        deleteBtns.forEach((item) => {
            item.addEventListener('click', (e) => {
                deleteItem(e.target.id);
            })
        });
    }

    //----------------------------------------Button functions-------------------------------------------
    async function editItem(button) {
        let id = button.id.split("-");

        let name = button.parentNode.parentNode.firstElementChild;
        let mass = name.nextElementSibling;
        let radius = mass.nextElementSibling;
        let methodOrDistance = radius.nextElementSibling;
        let starOrType = methodOrDistance.nextElementSibling;

        name.innerHTML = `<input class="form-control" type="text" name="name" placeholder="Name..." value = "${name.innerHTML}">`;
        mass.innerHTML = `<input class="form-control form-control-sm" type="number" name="mass" step="0.001" value = "${mass.innerHTML}">`;
        radius.innerHTML = `<input class="form-control form-control-sm" type="number" name="radius" step="0.001" value = "${radius.innerHTML}">`;


        if (id[1] == 'exoplanets') {
            let previousValueMethod = methodOrDistance.innerHTML;
            let previousValueStar = starOrType.innerHTML;
            methodOrDistance.innerHTML = await getSelect('methods');
            starOrType.innerHTML = await getSelect('stars');
            methodOrDistance.querySelector(`option[value="${previousValueMethod}"`).setAttribute("selected", "");
            starOrType.querySelector(`option[value="${previousValueStar}"]`).setAttribute("selected", "");
        }
        else if (id[1] == 'stars') {
            methodOrDistance.innerHTML = `<input class="form-control form-control-sm" type="number" name="distance" step="0.01" value = "${methodOrDistance.innerHTML}">`;
            starOrType.innerHTML = `<input class="form-control form-control-sm" type="text" name="type" placeholder="Type..." value = "${starOrType.innerHTML}">`;
        }

        button.value = "Confirm";
    }

    async function confirmEdition(button) {
        let id = button.id.split("-");

        let column = button.parentNode.parentNode.firstElementChild;
        let inputName = column.firstElementChild.value;
        column = column.nextElementSibling;
        let inputMass = column.firstElementChild.value;
        column = column.nextElementSibling;
        let inputRadius = column.firstElementChild.value;
        column = column.nextElementSibling;
        let inputMethodOrDistance = column.firstElementChild.value;
        column = column.nextElementSibling;
        let inputStarOrType = column.firstElementChild.value;

        let object;

        if (id[1] == 'exoplanets') {
            object = {
                "name": inputName,
                "mass": inputMass,
                "radius": inputRadius,
                "method": inputMethodOrDistance,
                "star": inputStarOrType,
            }
        }
        else if (id[1] == 'stars') {
            object = {
                "name": inputName,
                "mass": inputMass,
                "radius": inputRadius,
                "distance": inputMethodOrDistance,
                "type": inputStarOrType,
            }
        }

        try {
            let response = await fetch(`${url}/${id[1]}/${id[2]}`, {
                "method": "PUT",
                "headers": { "Content-Type": "application/json" },
                "body": JSON.stringify(object),
            });
            await unpack(response);
        }
        catch (Exc) {
            console.log(Exc);
            messageDiv.innerHTML = '<span class="alert alert-warning">There was an error when communicating with the server</span>';
        }

        loadTable(id[1]);

    }

    async function deleteItem(id) {
        let info = id.split('-');
        let idNumber = info.pop();
        let type = info.pop();

        try {
            let response = await fetch(url + "/" + type + "/" + idNumber, {
                "method": "DELETE",
            });

            await unpack(response);
        }
        catch (Exc) {
            console.log(Exc);
            messageDiv.innerHTML = '<span class="alert alert-warning">There was an error when communicating with the server</span>';
        }

        loadTable(type);
    }

    async function unpack(response) {
        let content = await response.text();
        messageDiv.innerHTML = content;
        messageDiv.classList.add(response.ok ? 'alert-success' : 'alert-warning');
        messageDiv.classList.remove(response.ok ? 'alert-warning' : 'alert-success');
    }

    //--------------------------------------Extra methods for rendering----------------------------------
    async function getSelect(type) {
        try {
            stringQuery = url.replace("tables", `select/${type}${type === 'methods' ? "/short" : ""}`);
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
}