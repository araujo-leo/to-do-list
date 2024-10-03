document.addEventListener('COMContentLoaded', listeners());


function listeners() {
    const login_form = document.getElementById('login-form');
    login_form.addEventListener('submit', function (e){
        e.preventDefault();
        login();
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





