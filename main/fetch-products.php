<?php
require __DIR__ . "/conn.php";

$query = "SELECT * FROM ram";
$result = $mysqli->query($query);

$rows = array();
if ($result->num_rows > 0) {
  $rows = $result->fetch_all(MYSQLI_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($rows);
?>
