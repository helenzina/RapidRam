<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["password"] === "1234" && $_POST["username"] === "admin") {
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];
    } else {
        header("Location: index.php");
        exit();
    }
}

if (empty($_SESSION["username"])) {
    header("Location: index.php");
    exit();
}

$mysqli = require __DIR__ . "/conn.php";
$query = "SELECT * FROM ram";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = array();
}

// Close the connection
$mysqli->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>RapidRam - Your spot for RAM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-3 sidenav">
                <ul class="nav nav-tabs nav-stacked" id="myTabs">
                    <li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
                    <li><a data-toggle="tab" href="#products">Products</a></li>
                    <li><a data-toggle="tab" href="#orders">Orders</a></li>
                </ul><br>
            </div>

            <div class="col-sm-9">
                <div class="tab-content">
                    <!-- Dashboard -->
                    <div id="dashboard" class="tab-pane fade in active">
                        <h2>Dashboard</h2>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Chart canvas will be placed here -->
                                    <canvas id="salesChart" width="100rem" style="display: flex;"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Logout admin -->
                        <form action="index.php" method="post">
                            <button type="submit" class="btn add logout pull-right">
                                Logout
                            </button>
                        </form>
                    </div>
                    <!-- Products -->
                    <div id="products" class="tab-pane fade">
                        <h2>Products</h2>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn add pull-right" data-toggle="modal" data-target="#addModal">
                            <i class="bi bi-plus"></i>
                            Add a product
                        </button>

                        <table class="table table-hover table-responsive" id="myTable1">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Capacity</th>
                                    <th scope="col">Channel</th>
                                    <th scope="col">Speed</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo $row['product_id']; ?>
                                        </th>
                                        <td>
                                            <?php echo $row['brand']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['model']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['capacity']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['channel']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['speed']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['price']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['photo']; ?>
                                        </td>
                                        <td>
                                            <!-- Edit -->
                                            <a href="#" class="edit-row" data-toggle="modal" data-target="#editModal">
                                                <i class="bi bi-pencil-square" style="color: green;"></i>
                                            </a>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal" tabindex="-1"
                                                aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="editModalLabel">
                                                                Edit product
                                                            </h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="edit.php" id="editForm" method="post">

                                                                <div class="mb-3">
                                                                    <label for="brand" class="form-label">Brand</label>
                                                                    <input type="text" class="form-control" name="brand"
                                                                        id="brand" aria-describedby="BrandHelp"
                                                                        value="<?php echo $row['brand']; ?>">
                                                                    <div id="BrandHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="model" class="form-label">Model</label>
                                                                    <input type="text" class="form-control" name="model"
                                                                        id="model" value="<?php echo $row['model']; ?>"
                                                                        aria-describedby="ModelHelp">
                                                                    <div id="ModelHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="capacity"
                                                                        class="form-label">Capacity</label>
                                                                    <input type="text" class="form-control" name="capacity"
                                                                        id="capacity" aria-describedby="CapacityHelp"
                                                                        value="<?php echo $row['capacity']; ?>">
                                                                    <div id="CapacityHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="channel" class="form-label">Channel</label>
                                                                    <input type="text" class="form-control" name="channel"
                                                                        id="channel" value="<?php echo $row['channel']; ?>"
                                                                        aria-describedby="ChannelHelp">
                                                                    <div id="ChannelHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="speed" class="form-label">Speed</label>
                                                                    <input type="text" class="form-control" name="speed"
                                                                        id="speed" value="<?php echo $row['speed']; ?>"
                                                                        aria-describedby="SpeedHelp">
                                                                    <div id="SpeedHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="price" class="form-label">Price</label>
                                                                    <input type="text" class="form-control" name="price"
                                                                        id="price" value="<?php echo $row['price']; ?>"
                                                                        aria-describedby="PriceHelp">
                                                                    <div id="PriceHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="photo" class="form-label">Photo</label>
                                                                    <input type="text" class="form-control"
                                                                        value="<?php echo $row['photo']; ?>" name="photo"
                                                                        id="photo" aria-describedby="PhotoHelp">
                                                                    <div id="PhotoHelp" class="form-text"></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="editBtn" class="btn save">
                                                                        Save changes
                                                                    </button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="#" class="delete-row" data-toggle="modal" data-target="#deleteModal">
                                                <i class="bi bi-trash" style="color: red;"></i>
                                            </a>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal" tabindex="-1"
                                                aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteModalLabel">
                                                                Delete product
                                                            </h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="delete.php" method="post">


                                                                <span>Are you sure you want to delete product
                                                                    <?php echo $row['product_id'] ?>?
                                                                </span>
                                                                <input type="hidden" name="product_id" id="product_id"
                                                                    value="<?php echo $row['product_id'] ?>">
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="deleteBtn"
                                                                        class="btn save">Submit</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>


                        <!-- Add -->
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="addModalLabel">
                                            Add a product
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        <form action="add.php" id="addForm" method="post">

                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Brand</label>
                                                <input type="text" class="form-control" name="brand" id="brand"
                                                    aria-describedby="BrandHelp">
                                                <div id="BrandHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="model" class="form-label">Model</label>
                                                <input type="text" class="form-control" name="model" id="model"
                                                    aria-describedby="ModelHelp">
                                                <div id="ModelHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="capacity" class="form-label">Capacity</label>
                                                <input type="text" class="form-control" name="capacity" id="capacity"
                                                    aria-describedby="CapacityHelp">
                                                <div id="CapacityHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="channel" class="form-label">Channel</label>
                                                <input type="text" class="form-control" name="channel" id="channel"
                                                    aria-describedby="ChannelHelp">
                                                <div id="ChannelHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="speed" class="form-label">Speed</label>
                                                <input type="text" class="form-control" name="speed" id="speed"
                                                    aria-describedby="SpeedHelp">
                                                <div id="SpeedHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="text" class="form-control" name="price" id="price"
                                                    aria-describedby="PriceHelp">
                                                <div id="PriceHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Photo</label>
                                                <input type="text" class="form-control" name="photo" id="photo"
                                                    aria-describedby="PhotoHelp">
                                                <div id="PhotoHelp" class="form-text"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cancel</button>
                                                <button type="submit" name="addBtn" class="btn save">
                                                    Submit
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Orders -->
                    <div id="orders" class="tab-pane fade">
                        <h2>Orders</h2>
                        <table class="table table-hover table-responsive" id="myTable2">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First name</th>
                                    <th scope="col">Last name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Billing address</th>
                                    <th scope="col">Product IDs</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody> <!-- for loop from db -->
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>mark@otto.com</td>
                                    <td>+12323143</td>
                                    <td>New York, NY 10012, US</td>
                                    <td>1, 20, 35</td>
                                    <td>...</td>
                                    <td>Delivered</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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