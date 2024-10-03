document.addEventListener('COMContentLoaded', listeners());


function listeners() {
    const login_form = document.getElementById('login-form');
    login_form.addEventListener('submit', function (e) {
        e.preventDefault();
        login();
    });



    const register_form = document.getElementById('sigin-form');
    register_form.addEventListener('submit', function (e) {
        e.preventDefault();
        register();


    });
}



//LOGIN
function login() {


    const login_data = {
        email: document.getElementById('user-email').value,
        password: document.getElementById('user-password').value
    };


    verify_login(login_data)
};

function verify_login(data) {
    fetch('http://localhost/to-do-list/backend/api/login', {

        method: 'POST',
        headers: {
            'Content-Type': 'application/json'

        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {

                enter_login();
                archive_login_token(result.token);


            } else {
                console.log("erro:", result.message);

            }
        })
        .catch(error => {
            console.error("Erro na requisição:", error);
        });


}
function enter_login() {
    window.location.href = "../index.html";
}
function archive_login_token(token) {
    localStorage.setItem('user_token', token);
}







//register


function register() {
    const data = {
        name: document.getElementById('new-user-name').value,
        email: document.getElementById('new-user-email').value,
        password: document.getElementById('new-user-password').value
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
            

            if (result.status === 'success') {
                alert("Usuário registrado com sucesso!");
            } else {
                console.log("Erro ao registrar o usuário:", result.message);
                alert("Erro ao registrar: " + result.message);
            }
        })
        .catch(error => {
            console.log('Erro na requisição:', error);
            console.log(result.status);
        });
        
};


















