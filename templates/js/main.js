let activeForm;

function showForm(formId) {
    let overlay = document.querySelector('.overlay');
    let timeout = 0;
    if (activeForm) {
        activeForm.classList.add('disappear');
        setTimeout(() => {activeForm.classList.add('none')}, 500);
        timeout = 500;
    }
    setTimeout(() => {
        activeForm = document.getElementById(formId);
        activeForm.classList.remove('none');
        activeForm.classList.remove('disappear');
        overlay.classList.remove('disblur');
        overlay.style.display = 'flex';
    }, timeout);
}

function closeActiveForm(){
    const overlay = document.querySelector('.overlay');
    overlay.classList.add('disblur');
    if (activeForm) {
        activeForm.classList.add('disappear');
        activeForm.classList.add('none');
    }
    setTimeout(() => {overlay.style.display = ''}, 1000);
    activeForm = null;
}

function cart() {
    const cartCount = document.querySelector('#cart-count');
    if (cartCount) {
        window.location.href = 'index.php?action=cart';
    }
    else {
        showForm('sign-in');
    }
}

function updateCartCount() {
    const cartCount = document.getElementById('cart-count');
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=cart&cartAction=count');
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            cartCount.innerHTML = xhr.responseText;
        }
    };
}

function getAccount() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=accountCard');
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != 1) {
                const overlay = document.querySelector('.overlay');
                const account = document.getElementById('account');
                if (account)
                    account.remove();
                overlay.insertAdjacentHTML('beforeend', xhr.responseText);
                showForm('account');
            }
            else {
                showForm('sign-in')
            }
        }
    };
}

function signOut(){
    window.location.href = 'index.php?action=sessionDestroy';
}

function editUserData(element){
    const accountCard = document.getElementById('account');
    switchEditable(element);
}

let previousValue;
function switchEditable(inputContainer) {
    const input = inputContainer.querySelector('input');
    const tool = inputContainer.querySelector('img');
    if (input.style.borderBottomColor != 'crimson')
        if (inputContainer.classList.contains('editable')) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'index.php?action=accountCard&accountCardAction=change');
            let formData = new FormData();
            formData.append('field', input.name);
            formData.append('value', input.value);
            xhr.send(formData);
            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(xhr);
                    if (xhr.responseText != 0) {
                        input.value = input.placeholder;
                    }
                }
            };
            inputContainer.classList.remove('editable');
            input.readOnly = true;
            tool.src = tool.src.replace('done.svg', 'edit.svg');
        }
        else {
            inputContainer.classList.add('editable');
            input.readOnly = false;
            tool.src = tool.src.replace('edit.svg', 'done.svg');
        }
}

function getChangePassword() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=accountCard&accountCardAction=passwordCard');
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != 1) {
                const overlay = document.querySelector('.overlay');
                const changePassword = document.getElementById('change-password');
                if (changePassword)
                    changePassword.remove();
                overlay.insertAdjacentHTML('beforeend', xhr.responseText);
                showForm('change-password');
            }
        }
    };
}

function changePassword() {
    event.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?action=accountCard&accountCardAction=changePassword');
    let formData = new FormData(document.getElementById('change-password'));
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == 0) {
                showDone('Пароль успешно изменен');
            }
            else {
                showAlert('Не удалось сменить пароль');
            }
        }
    };
}