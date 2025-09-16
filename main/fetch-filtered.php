<?php
require __DIR__ . "/conn.php";

$query = "SELECT SQL_CALC_FOUND_ROWS * FROM ram";
$whereClause = array();
$params = array();
$types = '';

$filterFields = ['capacity', 'channel', 'speed'];

foreach ($filterFields as $field) {
    if (isset($_POST[$field])) {
        $filterValue = $_POST[$field];
        if (is_array($filterValue)) {
            $placeholders = implode(',', array_fill(0, count($filterValue), '?'));
            $whereClause[] = "$field IN ($placeholders)";
            $params = array_merge($params, $filterValue);
            $types .= str_repeat('i', count($filterValue));
        } else {
            $whereClause[] = "$field = ?";
            $params[] = $filterValue;
            $types .= 'i';
        }
    }
}

if (isset($_POST['minPrice']) && isset($_POST['maxPrice'])) {
    $minPrice = $_POST['minPrice'];
    $maxPrice = $_POST['maxPrice'];
    $whereClause[] = "price BETWEEN ? AND ?";
    $params[] = $minPrice;
    $params[] = $maxPrice;
    $types .= 'ii';
}

if (!empty($whereClause)) {
    $query .= " WHERE " . implode(" AND ", $whereClause);
}

// Pagination
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$rows_per_page = 12;
$offset = ($page - 1) * $rows_per_page;

$query .= " LIMIT ?, ?";
$params[] = $offset;
$params[] = $rows_per_page;
$types .= 'ii';

$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    die('Prepare failed: ' . $mysqli->error);
}

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$rows = [];
if ($result->num_rows > 0) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
}

// Get total number of items without pagination
$totalResult = $mysqli->query("SELECT FOUND_ROWS() as total");
$totalItems = $totalResult->fetch_assoc()['total'];

$stmt->close();

header('Content-Type: application/json');
echo json_encode([
    'products' => $rows,
    'total' => $totalItems,
    'currentPage' => $page,
    'rowsPerPage' => $rows_per_page
]);
?>
