document.addEventListener("DOMContentLoaded", async function () {
    const productContainer = document.getElementById("product-container");
    const cartContainer = document.querySelector(".offcanvas-body");
    const openCartBtn = document.getElementById("open-cart-btn");
    const cartList = document.getElementById("cart");
    const totalSpan = document.getElementById("total");
    let total = 0;

    // Function to update the cart and total
    function updateCart(product, price, quantity) {
        const existingItem = Array.from(cartList.children).find(item => item.dataset.product === product);

        if (existingItem) {
            // If the product is already in the cart, update the quantity
            const quantitySpan = existingItem.querySelector(".quantity");
            quantitySpan.textContent = quantity;
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
        }

        // Update total
        total += price * quantity;
        totalSpan.textContent = new Intl.NumberFormat().format(total);
        
    }

    // Event listener for adding products to the cart
    productContainer.addEventListener("click", async function (event) {
        if (event.target.classList.contains("add-to-cart")) {
            const product = event.target.getAttribute("data-product");
            const price = parseFloat(event.target.getAttribute("data-price"));

            // For simplicity, let's assume quantity is 1
            const quantity = 1;

            updateCart(product, price, quantity);

            // Open the cart using Bootstrap offcanvas method
            const offcanvas = new bootstrap.Offcanvas(document.getElementById("offcanvasExample"));
            offcanvas.show();
        }
    });

    // Event listener for updating cart items
    document.addEventListener("click", async function (event) {
        if (event.target.classList.contains("add-item")) {
            const listItem = event.target.closest("li");
            const price = parseFloat(listItem.dataset.price);

            // Update quantity
            const quantitySpan = listItem.querySelector(".quantity");
            const quantity = parseInt(quantitySpan.textContent) + 1;
            quantitySpan.textContent = quantity;

            // Update total
            total += price;
            totalSpan.textContent = new Intl.NumberFormat().format(total);

            // Update the cart array in the session
            updateSessionCart();
        } else if (event.target.classList.contains("remove-item")) {
            const listItem = event.target.closest("li");
            const price = parseFloat(listItem.dataset.price);

            // Update quantity
            const quantitySpan = listItem.querySelector(".quantity");
            const quantity = parseInt(quantitySpan.textContent) - 1;

            if (quantity === 0) {
                // If quantity is zero, remove the item from the cart
                listItem.remove();
            } else {
                quantitySpan.textContent = quantity;
            }

            // Update total
            total -= price;
            totalSpan.textContent = new Intl.NumberFormat().format(total);

            // Update the cart array in the session
            updateSessionCart();
        }
    });

    // Event listener for opening checkout modal
    $('#checkoutModal').on('show.bs.modal', function (event) {
        // Get the product IDs and total from the cart and set them in the hidden fields
        const productIds = Array.from(cartList.children).map(item => item.dataset.product);
        const totalValue = total.toFixed(2);

        document.getElementById('productsInput').value = productIds.join(', ');
        document.getElementById('totalInput').value = totalValue;
    });

    // Event listener for submitting the checkout form
    const checkoutForm = document.getElementById("checkoutForm");
    checkoutForm.addEventListener("submit", async function (event) {
        // Prevent the default form submission
        event.preventDefault();
        alert("Thank you for your order!");
    });
});