
console.log(localStorage.getItem('user_token'));

document.addEventListener('DOMContentLoaded', verify_session());

function verify_session() {
    if (localStorage.getItem('user_token') == null) {
        window.location.href = 'pages/login-sigin.html';

    };
    listeners();
}

function listeners() {
    let logout_form = document.querySelector('#logout-form');

    logout_form.addEventListener('submit', function (event) {
        event.preventDefault();
        logout();


    });
}


function logout() {
    const data_logout = localStorage.getItem('user_token');
    

    verify_logout(data_logout);
}

function verify_logout(data) {
    fetch('http://localhost/to-do-list/backend/api/logout',
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + data             }
        })
        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {
                window.location.href = 'pages/login-sigin.html';
                localStorage.removeItem('user_token');
                console.log('Sucesso');
            } else {
                console.log("erro:", result.message);
                console.log('Bearer ' + data);
            }
        })
        .catch(error => {
            console.error("Erro na requisição:", error);
        });
}

   




