
document.addEventListener('DOMContentLoaded', function () {

    //REGISTER

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


    //LOGIN

    document.getElementById('login-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const user_password = document.getElementById('user-password').value;
        const user_email = document.getElementById('user-email').value;

        console.log("Email:", user_email);
        console.log("Password:", user_password);

        login(user_email, user_password);
    });
    function login(user_email, user_password) {
        const login_data = {
            email: user_email,
            password: user_password
        };

        fetch('http://localhost/to-do-list/backend/api/login', {

            method: 'POST',
            headers: {
                'Content-Type': 'application/json'

            },
            body: JSON.stringify(login_data)
        })
            .then(response => response.json())
            .then(result => {

                if (result.status === 'success') {
                    window.location.href = "../index.html";
                } else {
                    console.log("erro:", result.message);

                }


            })
            .catch(error => {
                console.error("Erro na requisição:", error);
            });





    }



















})