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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
                                    <canvas id="salesChart" width="100rem" style="display: flex;"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Logout admin -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <form action="index.php" method="post">
                                <button type="submit" class="btn btn-dark add logout pull-right">
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>mark@otto.com</td>
                                    <td>+12323143</td>
                                    <td>New York, NY 10012, US</td>
                                    <td>1, 20, 35</td>
                                    <td>150$</td>
                                    <td>Delivered</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jane</td>
                                    <td>Doe</td>
                                    <td>jane@doe.com</td>
                                    <td>+98765432</td>
                                    <td>Los Angeles, CA 90001, US</td>
                                    <td>5, 15, 28</td>
                                    <td>200$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">3</th>
                                    <td>John</td>
                                    <td>Smith</td>
                                    <td>john@smith.com</td>
                                    <td>+45678901</td>
                                    <td>Chicago, IL 60601, US</td>
                                    <td>8, 19, 42</td>
                                    <td>120$</td>
                                    <td>Shipped</td>
                                </tr>

                                <tr>
                                    <th scope="row">4</th>
                                    <td>Alice</td>
                                    <td>Johnson</td>
                                    <td>alice@johnson.com</td>
                                    <td>+11223344</td>
                                    <td>San Francisco, CA 94105, US</td>
                                    <td>3, 10, 25</td>
                                    <td>180$</td>
                                    <td>Delivered</td>
                                </tr>

                                <tr>
                                    <th scope="row">5</th>
                                    <td>Robert</td>
                                    <td>Williams</td>
                                    <td>robert@williams.com</td>
                                    <td>+99887766</td>
                                    <td>Miami, FL 33101, US</td>
                                    <td>12, 30, 48</td>
                                    <td>250$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">6</th>
                                    <td>Emily</td>
                                    <td>Anderson</td>
                                    <td>emily@anderson.com</td>
                                    <td>+55443322</td>
                                    <td>Seattle, WA 98101, US</td>
                                    <td>7, 18, 36</td>
                                    <td>160$</td>
                                    <td>Shipped</td>
                                </tr>

                                <tr>
                                    <th scope="row">7</th>
                                    <td>David</td>
                                    <td>Miller</td>
                                    <td>david@millter.com</td>
                                    <td>+66778899</td>
                                    <td>Denver, CO 80202, US</td>
                                    <td>2, 14, 30</td>
                                    <td>190$</td>
                                    <td>Delivered</td>
                                </tr>

                                <tr>
                                    <th scope="row">8</th>
                                    <td>Sarah</td>
                                    <td>Clark</td>
                                    <td>sarah@clark.com</td>
                                    <td>+33445566</td>
                                    <td>Phoenix, AZ 85001, US</td>
                                    <td>9, 22, 40</td>
                                    <td>140$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">9</th>
                                    <td>Michael</td>
                                    <td>Moore</td>
                                    <td>michael@moore.com</td>
                                    <td>+77889900</td>
                                    <td>Atlanta, GA 30301, US</td>
                                    <td>6, 16, 33</td>
                                    <td>210$</td>
                                    <td>Shipped</td>
                                </tr>

                                <tr>
                                    <th scope="row">10</th>
                                    <td>Olivia</td>
                                    <td>Roberts</td>
                                    <td>olivia@roberts.com</td>
                                    <td>+11223344</td>
                                    <td>Dallas, TX 75201, US</td>
                                    <td>11, 26, 45</td>
                                    <td>175$</td>
                                    <td>Delivered</td>
                                </tr>
                                <tr>
                                    <th scope="row">11</th>
                                    <td>Christopher</td>
                                    <td>Turner</td>
                                    <td>chris@turner.com</td>
                                    <td>+99887766</td>
                                    <td>Houston, TX 77002, US</td>
                                    <td>4, 17, 29</td>
                                    <td>195$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">12</th>
                                    <td>Emma</td>
                                    <td>Collins</td>
                                    <td>emma@collins.com</td>
                                    <td>+44556677</td>
                                    <td>Philadelphia, PA 19101, US</td>
                                    <td>10, 23, 38</td>
                                    <td>165$</td>
                                    <td>Shipped</td>
                                </tr>

                                <tr>
                                    <th scope="row">13</th>
                                    <td>Jason</td>
                                    <td>Ward</td>
                                    <td>jason@ward.com</td>
                                    <td>+22334455</td>
                                    <td>Detroit, MI 48201, US</td>
                                    <td>8, 21, 37</td>
                                    <td>180$</td>
                                    <td>Delivered</td>
                                </tr>

                                <tr>
                                    <th scope="row">14</th>
                                    <td>Mia</td>
                                    <td>Stewart</td>
                                    <td>mia@stewart.com</td>
                                    <td>+77889900</td>
                                    <td>Charlotte, NC 28201, US</td>
                                    <td>5, 15, 32</td>
                                    <td>210$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">15</th>
                                    <td>Andrew</td>
                                    <td>Hill</td>
                                    <td>andrew@hill.com</td>
                                    <td>+11223344</td>
                                    <td>San Diego, CA 92101, US</td>
                                    <td>12, 28, 43</td>
                                    <td>220$</td>
                                    <td>Shipped</td>
                                </tr>

                                <tr>
                                    <th scope="row">16</th>
                                    <td>Austin</td>
                                    <td>Taylor</td>
                                    <td>austin@taylor.com</td>
                                    <td>+99887766</td>
                                    <td>Austin, TX 78701, US</td>
                                    <td>7, 19, 34</td>
                                    <td>185$</td>
                                    <td>Processing</td>
                                </tr>

                                <tr>
                                    <th scope="row">17</th>
                                    <td>Houston</td>
                                    <td>Lee</td>
                                    <td>houston@lee.com</td>
                                    <td>+44556677</td>
                                    <td>Houston, TX 77001, US</td>
                                    <td>11, 25, 39</td>
                                    <td>200$</td>
                                    <td>Shipped</td>
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