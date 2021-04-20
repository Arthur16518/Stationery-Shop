window.onload = () => {updateOrderTotal()};

const makeOrderForm = document.getElementById('make-order');
makeOrderForm.onsubmit = function (e) {
    e.preventDefault();
    let formData = new FormData(makeOrderForm);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php?action=newOrder');
    let checked = document.querySelectorAll('.product-list input[type="checkbox"]:checked');
    if (checked.length == 0) {
        checked = document.querySelectorAll('.product-list input[type="checkbox"]');
    }
    if (checked.length == 0) {
        showAlert('Корзина пуста');
        return;
    }
    let productsData = [[],[]]; // [0] => id_product, [1] => count
    for (let item of checked) {
        const cartItem = item.parentElement;
        productsData[0].push(parseInt(cartItem.id));
        productsData[1].push(parseInt(cartItem.querySelector('input[type="number"]').value));
    }
    productsData = JSON.stringify(productsData);
    formData.append('productsData', productsData);
    xhr.send(formData);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText == '0') {
                for (let item of checked) {
                    item.parentElement.remove();
                }
                showDone('Заказ оформлен <br> Номер заказа отправлен на электронную почту');
                updateCartCount();
            }
            else
                showAlert('Возникла ошибка при оформлении заказа');
        }
    };
}

function updateTotal(numInput) {
    const cartItem = numInput.parentElement.parentElement.parentElement;
    const totalElement = cartItem.querySelector('.total-item-cost');
    const costElement = cartItem.querySelector('.cost');
    totalElement.innerHTML = parseFloat(costElement.innerHTML)*numInput.value;
    updateOrderTotal();
}

function updateOrderTotal() {
    let costs = [];
    if (checkedCount == 0)
        costs = document.querySelectorAll('.total-item-cost');
    else {
        let checkedInputs = document.querySelectorAll('input[type="checkbox"]:checked');
        for (let item of checkedInputs)
            costs.push(item.parentElement.querySelector('.total-item-cost'));
    }
    let total = 0;
    for (let item of costs) {
        total += parseFloat(item.innerHTML);
    }
    document.querySelector('#make-order .cost').innerHTML = total;
}

let checkedCount = 0;
function checkItem(checkbox) {
    if (checkbox.checked)
        checkedCount++;
    else
        checkedCount--;
    updateOrderTotal();
}

function deleteCartItem(cartItem) {
    let xhr = new XMLHttpRequest();
    let idProduct = parseInt(cartItem.id);
    xhr.open('GET', 'index.php?action=cart&cartAction=remove&id_product='+idProduct);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1') {
                cartItem.remove();
                updateCartCount();
            }
            else
                console.log('error');
        }
    };
}