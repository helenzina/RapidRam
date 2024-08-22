<?php
session_start();

require __DIR__ . "/conn.php";

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
  echo '<script>alert("Thank you for your order!")</script>';
}

if (isset($_POST['login'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  if ($username === "admin" && $password === "1234") {
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    header("Location: admin.php");
    exit;
  } else {
    echo '<script>
    alert("Username or password is incorrect. Please try again.");
    window.location.href = "index.php";
    </script>';
    exit;
  }
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
  <link rel="icon" href="../ram.svg">


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
            <form method="post" id="loginForm">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <br>
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="login" class="btn btn-dark save">Submit</button>
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
        <button type="button" class="btn btn-dark add checkout" data-bs-toggle="modal" data-bs-target="#checkoutModal">
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
          <form action="checkout.php" id="checkoutForm" method="post">
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
              <input type="email" required class="form-control" name="email" id="email" onchange="onChangeEmail()" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="tel" class="form-label">Phone</label>
              <input type="tel" required class="form-control" name="tel" id="tel"
                title="Phone number must be 10 digits." onchange="onChangeTel()" aria-describedby="telHelp">
              <div id="telHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="delivery_address" class="form-label">Delivery Address</label>
              <input type="text" required class="form-control" name="delivery_address" id="delivery_address"
                aria-describedby="delivery_addressHelp">
              <div id="delivery_addressHelp" class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="products" class="form-label">Products</label>
              <input type="text" readonly class="form-control" name="products" id="productsInput"
                aria-describedby="productsHelp">
              <div id="productsHelp" class="form-text"></div>
            </div>
            <input type="hidden" name="product_ids_and_quantities" id="productIdsAndQuantitiesInput" />
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
      <!-- Product cards will be added here dynamically -->
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

  <script src="../js/index.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

</body>

</html>