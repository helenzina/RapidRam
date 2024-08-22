document.addEventListener("DOMContentLoaded", async function () {
    const productContainer = document.getElementById("product-container");
    const totalSpan = document.getElementById("total");
    const cartList = document.getElementById("cart");
    let total = 0;
    const productQuantities = {};

    // Function to fetch product data from PHP
    async function fetchProducts() {
        const response = await fetch('fetch-products.php');
        const products = await response.json();
        return products;
    }

    // Function to build and display product cards
    function displayProducts(products) {
        productContainer.innerHTML = ''; // Clear the container

        const selectedIndexes = [2, 45, 6, 25, 30, 15];
        const selectedProducts = selectedIndexes.map(index => products[index]);

        // Handle case where some indexes might be out of bounds
        const validProducts = selectedProducts.filter(product => product);

        validProducts.forEach(product => {
            const productHTML = `
                <div class="col-sm-4 mb-2">
                    <div class="card" style="border-color: black;">
                        <div class="card-header" style="color: white; background-color: #333;">
                            DEAL -20%
                        </div>
                        <img src="../images/${product.photo}" class="card-img-top"
                            style="object-fit: contain; height: 100px; padding-top:5px;" alt="">
                        <div class="card-body">
                            <p class="card-text">
                                <span class="card-title" style="font-size: 1.2rem; font-weight: bold;">
                                    ${product.brand} ${product.model} ${product.capacity}GB ${product.speed}MHz
                                </span>
                                <br>
                                ${product.channel === "1" ? "Single Channel" : "Dual Channel"}
                                <br>
                                ${product.speed} MHz
                                <br>
                                <span style="display: flex; flex-direction: row-reverse;">
                                    <span style="text-decoration: line-through;">
                                        ${new Intl.NumberFormat().format(product.price * 1.2)} $
                                    </span>
                                    <span style="text-decoration: none; font-weight: bold;">
                                        ${new Intl.NumberFormat().format(product.price)} $
                                    </span>
                                </span>
                                <br>
                            </p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end input-group">
                                <button class="btn btn-light add-to-cart" 
                                    data-product="${product.brand} ${product.model} ${product.capacity}GB ${product.speed}MHz #${product.product_id}"
                                    data-price="${product.price}" data-quantity="1"> 
                                    <i class="bi bi-bag-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            productContainer.insertAdjacentHTML('beforeend', productHTML);
        });

        addEventListeners();
    }

    // Function to update the cart
    function updateCart(product, price, quantity) {
        const existingItem = Array.from(cartList.children).find(item => item.dataset.product === product);

        if (existingItem) {
            // If the product is already in the cart, update the quantity
            const quantitySpan = existingItem.querySelector(".quantity");
            const currentQuantity = parseInt(quantitySpan.textContent);
            const newQuantity = currentQuantity + quantity;
            quantitySpan.textContent = newQuantity;

            // Update product quantities in the cart
            productQuantities[product] = newQuantity;
        } else {
            // If the product is not in the cart, add it
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            listItem.dataset.product = product;
            listItem.dataset.price = price;
            listItem.innerHTML = `
                ${product} - $${new Intl.NumberFormat().format(price)} 
                <button class="btn btn-outline-secondary btn-sm mx-2 add-item">+</button> 
                <span class="quantity">${quantity}</span> 
                <button class="btn btn-outline-secondary btn-sm remove-item">-</button>
            `;
            cartList.appendChild(listItem);

            // Initialize product quantity in the cart
            productQuantities[product] = quantity;
        }

        // Update total
        total += price * quantity;
        totalSpan.textContent = new Intl.NumberFormat().format(total);

        // Update checkout information
        updateCheckout();
        // Update the cart array in the session
        updateSessionCart();
    }

    // Function to update the cart array in the session
    async function updateSessionCart() {
        const cartItems = Array.from(cartList.children).map(item => ({
            product: item.dataset.product,
            price: parseFloat(item.dataset.price),
            quantity: parseInt(item.querySelector(".quantity").textContent),
        }));

        await fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ cartItems }),
        });
    }

    // Function to update checkout modal
    async function updateCheckout() {
        const productIds = Object.keys(productQuantities);
        const totalValue = total.toFixed(2);

        document.getElementById('productsInput').value = productIds.map(id => productQuantities[id] + ' x #' + id).join(', ');
        document.getElementById('totalInput').value = totalValue;

        // Set the product IDs and quantities in the hidden field
        document.getElementById('productIdsAndQuantitiesInput').value = JSON.stringify(productQuantities);

        await fetch('checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productIdsAndQuantitiesInput: productQuantities }),
        });
    }

    // Add event listeners to dynamically added elements
    function addEventListeners() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const product = button.getAttribute('data-product');
                const price = parseFloat(button.getAttribute('data-price'));
                const quantity = parseInt(button.getAttribute('data-quantity'));

                updateCart(product, price, quantity); // Use the quantity from the button
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasExample'));
                offcanvas.show();
            });
        });

        document.addEventListener("click", function (event) {
            const listItem = event.target.closest('li');
            if (!listItem) return; // If there's no closest li, do nothing

            const price = parseFloat(listItem.dataset.price);
            const quantitySpan = listItem.querySelector('.quantity');
            let quantity = parseInt(quantitySpan.textContent);

            if (event.target.classList.contains('add-item')) {
                quantitySpan.textContent = ++quantity;
                productQuantities[listItem.dataset.product] = quantity;
                total += price;
            } else if (event.target.classList.contains('remove-item')) {
                if (quantity <= 1) {
                    listItem.remove();
                    delete productQuantities[listItem.dataset.product];
                } else {
                    quantitySpan.textContent = --quantity;
                    productQuantities[listItem.dataset.product] = quantity;
                }
                total -= price;
            }

            totalSpan.textContent = new Intl.NumberFormat().format(total);

            updateCheckout();
            updateSessionCart();
        });
    }

    $('#checkoutModal').on('show.bs.modal', function () {
        updateCheckout();
    });

    // Load and display products
    const products = await fetchProducts();
    displayProducts(products);
});

function onChangeEmail() {
    const email = document.querySelector('input[name=email]');
    const emailPattern = /[A-Za-z0-9._+-]+@[A-Za-z0-9 -]+\.[a-z]{2,}/;

    if (email.value.match(emailPattern)) {
        email.setCustomValidity('');
    } else {
        email.setCustomValidity('Email is not valid.');
    }
}

function onChangeTel() {
    const tel = document.querySelector('input[name=tel]');
    const telPattern= /[0-9]{10}/;

    if (tel.value.match(telPattern)) {
        tel.setCustomValidity('');
    } else {
        tel.setCustomValidity('Phone number is not valid.');
    }
} 
