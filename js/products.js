document.addEventListener("DOMContentLoaded", async function () {
    const productContainer = document.getElementById("product-container");
    const totalSpan = document.getElementById("total");
    const cartList = document.getElementById("cart");
    const paginationContainer = document.getElementById("pagination-container");
    let currentPage = 1;
    const itemsPerPage = 12;
    let total = 0;
    const productQuantities = {};

    // Function to fetch product data from PHP
    async function fetchProducts() {
        const response = await fetch('fetch-products.php');
        const products = await response.json();
        return products;
    }

    async function fetchFiltered() {
        const response = await fetch('fetch-filtered.php');
        const filtered = await response.json();
        return filtered;
    }

    // Function to build and display product cards
    function displayProducts(products) {
        productContainer.innerHTML = ''; // Clear the container

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedProducts = products.slice(startIndex, endIndex);

        paginatedProducts.forEach(product => {
            const productHTML = `
                <div class="col-sm-3 mb-2">
                    <div class="card" style="border-color: black;">
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
        renderPagination(products.length);
    }

    function renderPagination(totalItems) {
        paginationContainer.innerHTML = ''; // Clear existing pagination controls
    
        const totalPages = Math.ceil(totalItems / itemsPerPage);
    
        // Create the navigation element
        const navigation = document.createElement('nav');
        navigation.setAttribute('aria-label', 'Page navigation example');
    
        // Create the pagination list
        const paginationList = document.createElement('ul');
        paginationList.classList.add('pagination');
    
        // Create the "Previous" button
        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item');
        if (currentPage === 1) {
            prevItem.classList.add('disabled');
        }
        prevItem.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">Previous</span></a>`;
        prevItem.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                displayProducts(products);
            }
        });
        paginationList.appendChild(prevItem);
    
        // Create the page number buttons
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.classList.add('page-item');
            if (i === currentPage) {
                pageItem.classList.add('active');
            }
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                displayProducts(products);
            });
            paginationList.appendChild(pageItem);
        }
    
        // Create the "Next" button
        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item');
        if (currentPage === totalPages) {
            nextItem.classList.add('disabled');
        }
        nextItem.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">Next</span></a>`;
        nextItem.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                displayProducts(products);
            }
        });
        paginationList.appendChild(nextItem);
    
        // Append the pagination list to the navigation
        navigation.appendChild(paginationList);
    
        // Append the navigation to the pagination container
        paginationContainer.appendChild(navigation);
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
