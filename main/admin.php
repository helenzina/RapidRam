<?php
session_start();

if (empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    $_SESSION = array();
    echo "<script>alert('Logging out...')</script>";
    header("Location: index.php");
    exit;
}

$mysqli = require __DIR__ . "/conn.php";
$query = "SELECT * FROM ram";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = array();
}

$mysqli->close();

$mysqli = require __DIR__ . "/conn.php";
$query = "SELECT * FROM orders";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $orders = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $orders = array();
}

$mysqli->close();

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
    <link rel="icon" href="../ram.svg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-3 sidenav">
                <ul class="nav nav-tabs flex-column nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" type="button" role="tab"
                            aria-controls="dashboard-tab-pane" aria-selected="true"
                            data-bs-target="#dashboard-tab-pane">
                            Dashboard
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="products-tab" data-bs-toggle="tab" type="button" role="tab"
                            aria-controls="products-tab-pane" aria-selected="false" data-bs-target="#products-tab-pane">
                            Products
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="orders-tab" data-bs-toggle="tab" type="button" role="tab"
                            aria-controls="orders-tab-pane" aria-selected="false" data-bs-target="#orders-tab-pane">
                            Orders
                        </button>
                    </li>
                </ul><br>
            </div>

            <div class="col-sm-9">
                <div class="tab-content" id="myTabContent">
                    <!-- Dashboard -->
                    <div class="tab-pane fade show active" id="dashboard-tab-pane" role="tabpanel"
                        aria-labelledby="dashboard-tab" tabindex="0">
                        <h2>Dashboard</h2>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Chart canvas will be placed here -->
                                    <canvas id="salesChart" width="100rem" height="74rem"
                                        style="display: flex;"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Logout admin -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end">
                            <form method="post">
                                <button type="submit" name="logout" class="btn btn-dark add logout pull-right">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Products -->
                    <div class="tab-pane fade" id="products-tab-pane" role="tabpanel" aria-labelledby="products-tab"
                        tabindex="0">
                        <h2>Products</h2>
                        <!-- Button trigger modal -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-dark add pull-right" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                                <i class="bi bi-plus"></i>
                                Add a product
                            </button>
                        </div>
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
                                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                data-bs-target="#editModal<?php echo $row['product_id']; ?>">
                                                <i class="bi bi-pencil-square" style="color: green;"></i>
                                            </button>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editModal<?php echo $row['product_id']; ?>"
                                                tabindex="-1"
                                                aria-labelledby="editModalLabel<?php echo $row['product_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="editModalLabel<?php echo $row['product_id']; ?>">
                                                                Edit product
                                                            </h1>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="edit.php" id="editForm" method="post">
                                                                <div class="mb-3">
                                                                    <label for="brand" class="form-label">Brand</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="brand" id="brand"
                                                                        value="<?php echo $row['brand']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="model" class="form-label">Model</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="model" id="model"
                                                                        value="<?php echo $row['model']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="capacity"
                                                                        class="form-label">Capacity</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="capacity" id="capacity"
                                                                        value="<?php echo $row['capacity']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="channel" class="form-label">Channel</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="channel" id="channel"
                                                                        value="<?php echo $row['channel']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="speed" class="form-label">Speed</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="speed" id="speed"
                                                                        value="<?php echo $row['speed']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="price" class="form-label">Price</label>
                                                                    <input type="text" required class="form-control"
                                                                        name="price" id="price"
                                                                        value="<?php echo $row['price']; ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="photo" class="form-label">Photo</label>
                                                                    <input type="text" required class="form-control"
                                                                        value="<?php echo $row['photo']; ?>" name="photo"
                                                                        id="photo">
                                                                    <!-- Add this input field for product_id in the form -->
                                                                    <input type="hidden" name="product_id"
                                                                        value="<?php echo $row['product_id']; ?>">

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="editBtn"
                                                                        class="btn btn-dark save">
                                                                        Save changes
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?php echo $row['product_id']; ?>">
                                                <i class="bi bi-trash" style="color: red;"></i>
                                            </button>
                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal<?php echo $row['product_id']; ?>"
                                                tabindex="-1"
                                                aria-labelledby="deleteModalLabel<?php echo $row['product_id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="deleteModalLabel<?php echo $row['product_id']; ?>">
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
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" name="deleteBtn"
                                                                        class="btn btn-dark save">Submit</button>
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
                                                <input type="text" required class="form-control" name="brand" id="brand"
                                                    aria-describedby="BrandHelp">
                                                <div id="BrandHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="model" class="form-label">Model</label>
                                                <input type="text" required class="form-control" name="model" id="model"
                                                    aria-describedby="ModelHelp">
                                                <div id="ModelHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="capacity" class="form-label">Capacity</label>
                                                <input type="text" required class="form-control" name="capacity"
                                                    id="capacity" aria-describedby="CapacityHelp">
                                                <div id="CapacityHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="channel" class="form-label">Channel</label>
                                                <input type="text" required class="form-control" name="channel"
                                                    id="channel" aria-describedby="ChannelHelp">
                                                <div id="ChannelHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="speed" class="form-label">Speed</label>
                                                <input type="text" required class="form-control" name="speed" id="speed"
                                                    aria-describedby="SpeedHelp">
                                                <div id="SpeedHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price</label>
                                                <input type="text" required class="form-control" name="price" id="price"
                                                    aria-describedby="PriceHelp">
                                                <div id="PriceHelp" class="form-text"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">Photo</label>
                                                <input type="text" required class="form-control" name="photo" id="photo"
                                                    aria-describedby="PhotoHelp">
                                                <div id="PhotoHelp" class="form-text"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" name="addBtn" class="btn btn-dark save">
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
                    <div class="tab-pane fade" id="orders-tab-pane" role="tabpanel" aria-labelledby="orders-tab"
                        tabindex="0">
                        <h2>Orders</h2>
                        <table class="table table-hover table-responsive" id="myTable2">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First name</th>
                                    <th scope="col">Last name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Delivery address</th>
                                    <th scope="col">Products</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <th scope="row"><?php echo $order['id']; ?></th>
                                        <td><?php echo $order['firstname']; ?></td>
                                        <td><?php echo $order['lastname']; ?></td>
                                        <td><?php echo $order['email']; ?></td>
                                        <td><?php echo $order['tel']; ?></td>
                                        <td><?php echo $order['delivery_address']; ?></td>
                                        <td><?php echo $order['products']; ?></td>
                                        <td><?php echo $order['total']; ?></td>
                                        <td>Delivered</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="container-fluid text-center admin">
        <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
        <p><i class="bi bi-house-fill"></i> New York, NY 10012, US</p>
        <p><i class="bi bi-envelope-fill"></i> rapidram@info.com</p>
        <p><i class="bi bi-telephone"></i> + 01 234 567 89</p>
        <hr>
        <i class="bi bi-c-circle"></i>
        <span>RapidRam</span>
    </footer>

    <script src="../js/admin.js"></script>
    <script>

        $(document).ready(function () {
            // Handle the click event of the "Save changes" button in the edit modal
            $('.editBtn').click(function () {
                // Serialize the form data
                var formData = $('#editForm').serialize();

                // Send an AJAX request to edit.php
                $.ajax({
                    type: 'POST',
                    url: 'edit.php',
                    data: formData,
                    success: function () {
                        // On success, close the modal
                        $('#editModal<?php echo $row['product_id']; ?>').modal('hide');

                        // Refresh the table by reloading the current page
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        // Handle errors if needed
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>




</body>

</html>