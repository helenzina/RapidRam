<?php
session_start();

require __DIR__ . "/conn.php";

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkoutBtn"])) {
  echo '<script>alert("Thank you for your order!")</script>';
}

$query = "SELECT * FROM ram";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
  $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $rows = array();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>RapidRam - Your spot for RAM</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="../main/index.php">
        <i class="bi bi-memory"></i>
        RapidRam
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button class="nav-link" type="button" id="open-cart-btn" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <i class="bi bi-cart"></i>
              Cart
            </button>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginAdmin">
              <i class="bi bi-box-arrow-in-right"></i>
              Login <!-- if its admin then dnone cart and d-flex admin -->
            </a>
          </li>
      </div>
      </ul>
    </div>

    <div class="modal fade" id="loginAdmin" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">
              Enter password
            </h1>
          </div>
          <div class="modal-body">
            <form action="admin.php" method="post" id="loginForm">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <br>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-dark save">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </nav>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Shopping Cart</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div id="cart-content">
        <ul id="cart" class="list-group mb-3">
          <!-- Cart items will be added here dynamically -->
        </ul>
        <h6>Total: $<span id="total">0.00</span></h6>
      </div>
      <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-top: 35rem">
        <button type="button" class="btn btn-dark add" data-bs-toggle="modal" data-bs-target="#checkoutModal">
          <i class="bi bi-bag-check"></i>
          Checkout
        </button>
      </div>
    </div>
  </div>

  <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="checkoutModalLabel">
            Order checkout
          </h1>
        </div>
        <div class="modal-body">
          <form id="checkoutForm" method="post">
            <div class="mb-3">
              <label for="firstname" class="form-label">First name</label>
              <input type="text" required class="form-control" name="firstname" id="firstname"
                aria-describedby="firstnameHelp">
              <div id="firstnameHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">Last name</label>
              <input type="text" required class="form-control" name="lastname" id="lastname"
                aria-describedby="lastnameHelp">
              <div id="lastnameHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" required class="form-control" name="email" id="email" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="tel" class="form-label">Phone</label>
              <input type="text" required class="form-control" name="tel" id="tel" aria-describedby="telHelp">
              <div id="telHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Delivery Address</label>
              <input type="text" required class="form-control" name="address" id="address"
                aria-describedby="addressHelp">
              <div id="addressHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="products" class="form-label">Products</label>
              <input type="text" readonly class="form-control" name="products" id="productsInput"
                aria-describedby="productsHelp">
              <div id="productsHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="total" class="form-label">Total</label>
              <input type="text" readonly class="form-control" name="total" id="totalInput"
                aria-describedby="totalHelp">
              <div id="totalHelp" class="form-text"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="checkoutBtn" class="btn btn-dark save">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="container" id="home">
    <div class="row" id="product-container">
      <?php
      $selectedIndices = [2, 40, 6, 28, 60, 12];

      foreach ($selectedIndices as $index) {
        $row = $rows[$index];
        ?>
        <div class="col-sm-4 mb-2">
          <div class="card" style="border-color: black;">
            <div class="card-header" style="color: white; background-color: #333;">
              DEAL -20%
            </div>
            <img src="../images/<?php echo $row["photo"]; ?>" class="card-img-top"
              style="object-fit: contain; height: 100px; padding-top:5px;" alt="">
            <div class="card-body">
              <p class="card-text">
                <span class="card-title" style="font-size: 1.2rem; font-weight: bold;">
                  <?php echo $row['brand'] . ' ' . $row['model']; ?>
                </span>
                <br>
                <?php echo $row['capacity']; ?> GB
                <br>
                <?php echo ($row['channel'] === "1") ? "Single Channel" : "Dual Channel"; ?>
                <br>
                <?php echo $row['speed']; ?> MHz
                <br>
                <span style="display: flex; flex-direction: row-reverse;">
                  <span style="text-decoration: line-through;">
                    <?php echo number_format($row['price'] * 1.2) . " $"; ?>
                  </span>
                  <span style="text-decoration: none; font-weight: bold;">
                    <?php echo number_format($row['price']) . " $"; ?>
                  </span>
                </span>
                <br>
              </p>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end input-group">
                <button class="btn btn-light add-to-cart" data-product="<?php echo $row['brand'] . ' ' . $row['model']
                  . ' ' . $row['capacity'] . 'GB' . ' ' . $row['speed'] . 'MHz' . ' #' . $row['product_id'];
                ?>" data-price="<?php echo $row['price']; ?>">
                  <i class="bi bi-bag-fill"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>

    </div>
  </div>
  <br>

  <br><br>

  <footer class="container-fluid text-center">

    <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
    <p><i class="bi bi-house-fill"></i> New York, NY 10012, US</p>
    <p><i class="bi bi-envelope-fill"></i> rapidram@info.com</p>
    <p><i class="bi bi-telephone"></i> + 01 234 567 89</p>
    <hr>
    <i class="bi bi-c-circle"></i>
    <span>RapidRam</span>
  </footer>

  <script src="../js/admin.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
    <script>
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
        
        // Update the cart array in the session
        updateSessionCart();
    }

    // Function to update the cart array in the session
    function updateSessionCart() {
        const cartItems = Array.from(cartList.children).map(item => ({
            product: item.dataset.product,
            price: parseFloat(item.dataset.price),
            quantity: parseInt(item.querySelector(".quantity").textContent),
        }));
        // Update the cart array in the session
        <?php echo "const sessionId = '" . session_id() . "';"; ?>
        fetch('update-cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ sessionId, cartItems }),
        });
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
</script>

</body>

</html>