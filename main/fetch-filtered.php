<?php
require __DIR__ . "/conn.php";

$query = "SELECT * FROM ram";
$whereClause = array();

// List of filterable fields
$filterFields = ['capacity', 'channel', 'speed'];

foreach ($filterFields as $field) {
    if (isset($_POST[$field])) {
        $filterValue = $_POST[$field];
        if (is_array($filterValue)) {
            $filterValue = implode(',', $filterValue);
            $whereClause[] = "$field IN ($filterValue)";
        } else {
            $whereClause[] = "$field = $filterValue";
        }
    }
}

// Check if price range filter is set
if (isset($_POST['minPrice']) && isset($_POST['maxPrice'])) {
    $minPrice = $_POST['minPrice'];
    $maxPrice = $_POST['maxPrice'];
    $whereClause[] = "price BETWEEN $minPrice AND $maxPrice";
}

if (!empty($whereClause)) {
    $query .= " WHERE " . implode(" AND ", $whereClause);
}

// Execute the query after applying filters
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Pagination
    $rows_per_page = 12;
    $total_pages = ceil(count($rows) / $rows_per_page);

    // Get current page from the URL
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $page = max(1, min($page, $total_pages));

    // Calculate the offset for fetching rows
    $start = ($page - 1) * $rows_per_page;

    // Modify the query to include the LIMIT clause
    $query .= " LIMIT $start, $rows_per_page";

    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $rows = array();
    }
} else {
    $rows = array();
    echo '<script>
    alert("No products were found with these filters.");
    window.location.href = "products.php?clear=true";
    </script>';
}

header('Content-Type: application/json');
echo json_encode($rows);
?>
