<?php

require __DIR__ . "/conn.php";

//$is_invalid = false;

//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $username = $_POST["username"];
//    $password = $_POST["password"];
//
//    if ($username !== "admin" || $password !== "1234") {
//        $is_invalid = true;
//    }
//}

$query = "SELECT * FROM ram";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = array();
}

//$mysqli->close();
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
          <li><a href="#home">Home</a></li>
          <li><a href="products.php">Products</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="cart.php">
              <i class="bi bi-cart"></i>
              Cart
            </a>
          </li>
          <li>
            <a data-toggle="modal" data-target="#loginAdmin">
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
                Login
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
  </nav>


  <div class="container" id="home">
    <div class="row">
      <?php

      $selectedIndices = [2, 40, 6, 28, 60, 12];

      foreach ($selectedIndices as $index) {
        $row = $rows[$index];
        ?>
        <div class="col-sm-4">
          <div class="panel panel-primary" style="height: 450px;">
            <div class="panel-heading">DEAL -20%</div>
            <div class="panel-body" style="height: 50%; overflow: hidden;">
              <img src="../images/<?php echo $row["photo"]; ?>" class="img-responsive" alt="Image"
                style="width: 100%; height: 100%;">
            </div>
            <p style="height: 30%; box-sizing: border-box; overflow: hidden; padding: 10px;">
              <span style="font-size: 2rem; font-weight: bold;">
                <?php echo $row['brand']; ?>
                <?php echo $row['model']; ?>
              </span>
              <br>
              <?php echo $row['capacity']; ?> GB
              <br>
              <?php if ($row['channel'] === "1") {
                echo "Single Channel";
              } else {
                echo "Dual Channel";
              } ?>
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
            <button type="submit" class="btn bag">
              <i class="bi bi-bag-fill"></i>
            </button>
          </div>
        </div>
        <?php
      }
      ?>

    </div>
  </div><br>



  <br><br>

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