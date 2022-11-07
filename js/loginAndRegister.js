"use strict"

document.addEventListener('DOMContentLoaded', loginAndRegister);

function loginAndRegister() {
    let url = window.location.href;
    let messageDiv = document.querySelector('#message');
    let form = document.querySelector('.user-form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        submit();
    });

    async function submit() {
        let data = new FormData(form);

        let user = {
            "username": data.get('user'),
            "password": data.get('pass'),
        }

        let response = await fetch(url, {
            "method": "POST",
            "headers": { "Content-Type": "application/json" },
            "body": JSON.stringify(user),
        })

        messageDiv.classList.add('alert');
        messageDiv.innerHTML = await response.text();
        messageDiv.classList.add(response.ok ? 'alert-success' : 'alert-warning');

        if (response.status == 200) {
            setTimeout(() => { window.location.replace(url.replace("login", "home")) }, 1500);
        }

    }
}