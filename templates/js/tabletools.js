function deleteRecord(td) {
    let xhr = new XMLHttpRequest();
    let id = td.parentElement.querySelector('.ID input').value;
    xhr.open('POST', 'index.php?action=cms&recordAction=delete');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('table='+document.querySelector('table').id+'&id='+id);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1'){
                td.parentElement.remove();
            } else {
                console.log('error');
            }
        }
    }
}

function editRecord(td) {
    let data = collectRowData(td.parentElement);
    let id = td.parentElement.querySelector('.ID input').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?action=cms&recordAction=edit');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('table='+document.querySelector('table').id+'&id='+id+'&'+data);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '1') {
                td.parentElement = currentEditableRow;
                console.log('error');
            }
        }
    }
}

let activeImg;
let currentEditableRow;
function switchEditButton(img) {
    if (activeImg && img != activeImg)
        switchEditButton(activeImg);
    if (img.src.indexOf('edit') != -1) {
        img.src = img.src.replace('edit', 'done');
        activeImg = img;
        currentEditableRow = img.parentElement.parentElement;
    } else {
        img.src = img.src.replace('done', 'edit');
        activeImg = null;
        currentEditableRow = null;
        editRecord(img.parentElement);
    }
    for (let item of img.parentElement.parentElement.querySelectorAll('input[type="text"], textarea, select')) {
        if (!item.parentElement.classList.contains('ID'))
            activateInput(item);
    }
}

function activateInput(input) {
    if (input.readOnly || input.disabled) {
        if (input.localName == 'select')
            input.disabled = false;
        else
            input.readOnly = false;
        input.parentElement.style.backgroundColor = '#A4A4A4';
    }
    else {
        if (input.localName == 'select')
            input.disabled = true;
        else
            input.readOnly = true;
        input.parentElement.style.backgroundColor = '';
    }
}

function collectRowData(tr) {
    const inputs = tr.querySelectorAll('input[type="text"], textarea, select');
    let result = '';
    for (let item of inputs) {
        if (result != '')
            result = result+'&';
        result = result+item.name+'='+item.value;
    }
    console.log(result);
    return result;
}