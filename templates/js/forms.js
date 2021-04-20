const signInForm = document.getElementById('sign-in');
const signUpForm = document.getElementById('sign-up');
const adminSignInForm = document.getElementById('admin-sign-in');
const passwordReset = document.getElementById('password-reset');

let loginInputs = document.querySelectorAll('#sign-up input[name="login"], #sign-up input[name="email"]');
for (let input of loginInputs){
    input.onchange = () => checkUniqueness(input);
}

let password1 = document.querySelector('#sign-up #password');
let password2 = document.querySelector('#sign-up #password2');
password2.onchange = () => comparePasswords(password1, password2);

signInForm.onsubmit = function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const formData = new FormData(signInForm);
    xhr.open('POST', 'index.php?action=signIn');
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                closeActiveForm();
                document.getElementById('sign-in-link').classList.add('none');
                document.getElementById('to-account').classList.remove('none');
                window.location.reload();
            }
            else if (xhr.responseText == '1') {
                showAlert('Неверный логин или пароль');
            }
            else {
                closeActiveForm();
            }
        }
    };
    clearAllInputs();
}

signUpForm.onsubmit = function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const formData = new FormData(signUpForm);
    xhr.open('POST', 'index.php?action=signUp');
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                closeActiveForm();
                document.getElementById('sign-in-link').classList.add('none');
                document.getElementById('to-account').classList.remove('none');
                showDone('Регистрация прошла успешно');
                setTimeout(() => {window.location.reload();}, 500);
            }
            else if (xhr.responseText == '1') {
                showAlert('Регистрация не удалась');
            }
            else {
                closeActiveForm();
            }
        }
    };
    clearAllInputs();
}

adminSignInForm.onsubmit = function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const formData = new FormData(adminSignInForm);
    xhr.open('POST', 'index.php?action=adminSignIn');
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                closeActiveForm();
                window.location.href = 'index.php?action=cms';
            }
            else if (xhr.responseText == '1') {
                showAlert('Неверный логин или пароль');
            }
            else {
                closeActiveForm();
            }
        }
    };
    clearAllInputs();
}

function showAlert(text) {
    document.querySelector('#alert .message').innerHTML = text;
    showForm('alert');
}

function showDone(text) {
    document.querySelector('#done .message').innerHTML = text;
    showForm('done');
}

function clearAllInputs() {
    let inputs = document.querySelectorAll('input[type="text"], input[type="password"], input[type="tel"], input[type="email"]');
    for (item of inputs) {
        item.value = '';
    }
}

function checkUniqueness(input) {
    let submit = input.form.querySelector('*[type="submit"]');
    if (input.value == input.placeholder){
        input.style.borderBottomColor = 'black';
        return;
    }
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=checkUniqueness&login='+input.value);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                input.style.borderBottomColor = 'green';
                submit.disabled = false;
            }
            else {
                input.style.borderBottomColor = 'crimson';
                submit.disabled = true;
            }
        }
    };
}

function comparePasswords(input1, input2) {
    if (input1.value == input2.value) {
        input2.style.borderBottomColor = 'green';
        input2.form.querySelector('*[type="submit"]').disabled = false;
    }
    else {
        input2.style.borderBottomColor = 'crimson';
        input2.form.querySelector('*[type="submit"]').disabled = true;
    }
}

var whoReset;

passwordReset.onsubmit = function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    const formData = new FormData(passwordReset);
    xhr.open('POST', 'index.php?action=resetPassword');
    formData.append('whoReset', whoReset);
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                showAlert('Новый пароль отправлен вам на электронную почту');
            }
            else if (xhr.responseText == '1') {
                showAlert('Не удалось восстановить пароль');
            }
            else {
                closeActiveForm();
            }
        }
    };
    clearAllInputs();
}