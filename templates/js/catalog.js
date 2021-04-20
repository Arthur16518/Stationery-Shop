function addToCart(event, idProduct = null) {
    event.stopPropagation();
    if (!idProduct) {
        showForm('sign-in');
        return;
    }
    else {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'index.php?action=cart&cartAction=addToCart&id_product='+idProduct);
        xhr.send();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(xhr);
                if (xhr.responseText != '-1') {
                    document.querySelector('#cart-count').innerHTML = xhr.responseText;
                    disableAddToCart(idProduct)
                }
                else
                    console.log('error');
            }
        };
    }
}

function disableAddToCart(idProduct) {
    const productElement = document.querySelector('input[value="'+idProduct+'"][name="id_product"]').parentElement;
    let button = productElement.querySelector('.add-to-cart');
    button.disabled = true;
    button.innerHTML = button.innerHTML.replace('у', 'е');
}

function sortProducts(sortOption, idCategory) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=catalog&id_category='+idCategory+'&sort='+sortOption);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '-1') {
                let products = document.querySelector('.products');
                const sortBlock = document.querySelector('.sort-block');
                products.innerHTML = xhr.responseText;
                products.insertBefore(sortBlock, document.querySelector('.product'));
            }
            else
                console.log('error');
        }
    };
}

function getProduct(productId) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=catalog&id_product='+productId);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1') {
                let card = document.getElementById('product-card');
                if (card) {
                    card.remove();
                }
                let overlay = document.querySelector('.overlay');
                overlay.insertAdjacentHTML('beforeend', xhr.responseText);
                showForm('product-card');
            }
            else
                console.log('error');
        }
    };
}

function getManufacturer(manufacturerId) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'index.php?action=catalog&id_manufacturer='+manufacturerId);
    xhr.send();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(xhr);
            if (xhr.responseText != '1') {
                let card = document.getElementById('manufacturer-card');
                if (card) {
                    card.remove();
                }
                let overlay = document.querySelector('.overlay');
                overlay.insertAdjacentHTML('beforeend', xhr.responseText);
                showForm('manufacturer-card');
            }
            else
                console.log('error');
        }
    };
}