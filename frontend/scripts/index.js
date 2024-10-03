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
                'Authorization': `${JSON.stringify("Bearer "+ data)}`
            }
        })



        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {

                window.location.href = 'pages/login-sigin.html';

                console.log('Sucesso')
            } else {
                console.log("erro:", result.message);
                //console.log(localStorage.getItem('user_token'));
                console.log(`${JSON.stringify("Bearer "+ data)}`);

            }


        })
        .catch(error => {
            console.error("Erro na requisição:", error);
        });
}


   

    
/* 

document.getElementById('sigin-form').addEventListener('submit', function (event) {
    event.preventDefault();
    const new_user_name = document.getElementById('new-user-name').value;
    const new_user_password = document.getElementById('new-user-password').value;
    const new_user_email = document.getElementById('new-user-email').value;

    sigin(new_user_name, new_user_email, new_user_password);
});


function sigin(user_name, user_email, user_password) {
    const data = {
        name: user_name,
        email: user_email,
        password: user_password
    };


    fetch('http://localhost/to-do-list/backend/api/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            // erro: sempre caindo no catch mas está registrando.
            if (result.status === 'success') {
                alert("Usuário registrado com sucesso!");
            } else {
                console.log("Erro ao registrar o usuário:", result.message);
                alert("Erro ao registrar: " + result.message);
            }
        })
        .catch(error => {
            // erro console.log('Erro na requisição:', error);

        });
};















*/



