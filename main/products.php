<?php
session_start();

$mysqli = require __DIR__ . "/conn.php";

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/index.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../main/index.php">
                    <i class="bi bi-memory"></i>
                    RapidRam
                </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php#home">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="cart.php">
                            <i class="bi bi-cart"></i>
                            Cart
                        </a>
                    </li>
                    <li><a data-toggle="modal" data-target="#loginAdmin">
                    <i class="bi bi-box-arrow-in-right"></i>
                            Login <!-- if its admin then dnone cart and d-flex admin -->
                        </a>
                    </li>
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
                  <label for="username">Username</label>
                  <input type="text" id="username" name="username" required>
                  <br>
                  <label for="password">Password</label>
                  <input type="password" id="password" name="password" required>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn save">Submit</button>
                </div>
              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar with filter options -->
            <nav class="navbar navbar-header col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <button class="btn btn-dark d-md-none navbar-toggle filters" type="button" data-toggle="collapse"
                    data-target="#sidebar">
                    <i class="bi bi-layout-sidebar"></i>
                </button>

                <div class="position-sticky collapse navbar-collapse" id="sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h4 class="nav-link"><b>Filters</b></h5>
                                <br>
                        </li>

                        <!-- Capacity filter -->
                        <li class="nav-item">
                            <label for="capacity">Capacity</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="8gb" name="capacity">
                                <label class="form-check-label" for="8gb">8GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="16gb" name="capacity">
                                <label class="form-check-label" for="16gb">16GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="32gb" name="capacity">
                                <label class="form-check-label" for="32gb">32GB</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="64gb" name="capacity">
                                <label class="form-check-label" for="64gb">64GB</label>
                            </div>
                        </li>
                        <br>
                        <!-- Channel filter -->
                        <li class="nav-item">
                            <label for="channel">Channel</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="channel" name="channel">
                                <label class="form-check-label" for="singleChannel">Single Channel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="channel" name="channel">
                                <label class="form-check-label" for="dualChannel">Dual Channel</label>
                            </div>
                        </li>
                        <br>
                        <!-- Speed filter -->
                        <li class="nav-item">
                            <label for="speed">Speed</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="2666MHz" name="capacity">
                                <label class="form-check-label" for="2666MHz">2666MHz</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="3000MHz" name="capacity">
                                <label class="form-check-label" for="3000MHz">3000MHz</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="3200MHz" name="capacity">
                                <label class="form-check-label" for="3200MHz">3200MHz</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="3600MHz" name="capacity">
                                <label class="form-check-label" for="3600MHz">3600MHz</label>
                            </div>
                        </li>
                        <br>
                        <!-- Price range filter -->
                        <li class="nav-item">
                            <label for="priceRange">Price Range</label>
                            <input class="form-control form-control-sm" type="text" id="minPrice" name="minPrice"
                                value="0">
                            <label class="form-check-label" for="minPrice"></label>
                            <input class="form-control form-control-sm" type="text" id="maxPrice" name="maxPrice"
                                value="200">
                            <label class="form-check-label" for="maxPrice"></label>
                        </li>
                        <button type="submit" class="btn save">Submit</button>
                    </ul>
                </div>
            </nav>

            <!-- Main content area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container">
                    <div class="row">
                        <?php foreach ($rows as $row) { ?>
                            <div class="col-sm-4">
                                <div class="panel panel-primary">
                                    <div class="panel-body" style="height: 50%; overflow: hidden;">
                                        <img src="../images/<?php echo $row["photo"]; ?>" class="img-responsive"
                                            alt="Image" style="width: 100%; height: 100%;">
                                    </div>
                                    <p style="height: 30%; box-sizing: border-box; overflow: hidden; padding: 10px;">
                                        <span style="font-size: 2rem; font-weight: bold;">
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
                                            <span>
                                                <?php echo $row['price'] . " $"; ?>
                                            </span>
                                        </span>
                                        <br>
                                    </p>
                                    <button type="submit" class="btn bag">
                                        <i class="bi bi-bag-fill"></i>
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="container-fluid text-center">
        <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
        <p><i class="bi bi-house-fill"></i> New York, NY 10012, US</p>
        <p><i class="bi bi-envelope-fill"></i> info@gmail.com</p>
        <p><i class="bi bi-telephone"></i> + 01 234 567 89</p>
        <hr>
        <i class="bi bi-c-circle"></i>
        <span>RapidRam</span>
    </footer>

    <script src="../js/admin.js"></script>

</body>

</html>
