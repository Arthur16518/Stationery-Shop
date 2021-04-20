let sections = document.querySelector('.sections').children;
for (let h2 of sections) {
    h2.onclick = () => getTools(h2);
}

function getTools(h2element) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=cms&data='+h2element.innerHTML);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                document.querySelector('.main-section').innerHTML = xhr.responseText;
                const table = document.querySelector('table');
                if (table.id == 'orders')
                    prepareOrders(table);
            }
            else {
                console.log('error');
            }
        }
    };
}

function prepareOrders(table) {
    let trs = table.querySelectorAll('tbody tr');
    for (let tr of trs) {
        tr.classList.add('hoverable-row');
        let orderId = tr.querySelector('.ID input').value;
        tr.onclick = () => getOrderData(orderId);
    }
}

function getOrderData(orderId) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=cms&cmsAction=getOrderProducts&id_order='+orderId);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                let orderProducts = document.getElementById('order-products');
                if (orderProducts)
                    orderProducts.remove();
                overlay.innerHTML = overlay.innerHTML + xhr.responseText;
                showForm('order-products');
            }
            else {
                console.log('error');
            }
        }
    };
}

let activeForm;

function showPictureForm(originalImg, fieldName) {
    const prevPic = document.getElementById('previous-picture').querySelector('img');
    prevPic.src = originalImg.src;
    prevPic.id = fieldName+'&'+originalImg.parentElement.parentElement.querySelector('.ID input').value;
    const newPicture = document.querySelector('#new-picture img');
    newPicture.src = '';
    newPicture.classList.add('none');
    document.querySelector('#new-picture input[type="file"]').classList.remove('none');
    showForm('picture-form');
}

function showForm(formId) {
    const overlay = document.querySelector('.overlay');
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

const pictureForm = document.getElementById('picture-form');

pictureForm.onsubmit = function (e) {
    e.preventDefault();
    let formData = new FormData(pictureForm);
    let fieldAndId = pictureForm.querySelector('#previous-picture img').id.split('&');
    formData.append('table', document.querySelector('table').id);
    formData.append('field', fieldAndId[0]);
    formData.append('id', fieldAndId[1]);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?action=cms&cmsAction=loadPicture');
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                const newPicture = document.querySelector('#new-picture img');
                newPicture.src = xhr.responseText;
                newPicture.classList.remove('none');
                document.querySelector('#new-picture input[type="file"]').classList.add('none');
                getTools(document.querySelector('#tableName'));
                setTimeout(closeActiveForm, 500);
            }
            else {
                console.log('error');
            }
        }
    };
    pictureForm.querySelector('input[type="file"]').value = null;
}

const overlay = document.querySelector('.overlay');
function getAddRecordForm(tableName) {
    let addRecordForm = document.querySelector('#add-record-form');
    if (addRecordForm) {
        addRecordForm.remove();
    }
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=cms&cmsAction=getForm&table='+tableName);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                overlay.innerHTML = overlay.innerHTML + xhr.responseText;
                addRecordForm = document.querySelector('#add-record-form');
                addRecordForm.onsubmit = (e) => addRecord(e, addRecordForm);
                showForm('add-record-form');
            }
            else {
                console.log('error');
            }
        }
    };
}

function addRecord(e, form) {
    e.preventDefault();
    let formData = new FormData(form);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?action=cms&cmsAction=addRecord');
    xhr.send(new FormData(form));
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                getTools(document.querySelector('#tableName'));
                closeActiveForm();
            }
            else {
                console.log('error');
            }
        }
    };
}

function checkAdminLogin(input) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=checkAdminLogin&login='+input.value);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0'){
                input.style.borderBottomColor = 'green';
                input.form.querySelector('*[type="submit"]').disabled = false;
            }
            else {
                input.style.borderBottomColor = 'crimson';
                input.form.querySelector('*[type="submit"]').disabled = true;
            }
        }
    };
}