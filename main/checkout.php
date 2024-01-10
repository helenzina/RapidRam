<?php
session_start();

if(empty($_SESSION['user_id'])){
    header("Location: login.php");
 }

$mysqli = require __DIR__ . "/conn.php";
require __DIR__ . "/../vendor/autoload.php";

$stripe_secret_key = "sk_test_51OM3jGGNq9khvLayBm5WV84F957gkPlE1DoMBo9LYaFY8KEc5LsXcMD3dpOx03ikRuIxXvBEvxnGgPU3gSatNXKg0027eTlJYq";
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Retrieve the selected plan value from the query parameters
$selectedPlan = $_GET['plan'];

$subscriptionStartDate = date('Y-m-d');
$subscriptionEndDate = date('Y-m-d', strtotime("+$selectedPlan months", strtotime($subscriptionStartDate)));

$_SESSION["selected_plan"] = $selectedPlan;
$_SESSION["subscription_start_date"] = $subscriptionStartDate;
$_SESSION["subscription_end_date"] = $subscriptionEndDate;

// Adjust the unit amount based on the selected plan
if ($selectedPlan == '3') {
    $unitAmount = 2399; // Basic plan
} elseif ($selectedPlan == '6') {
    $unitAmount = 4499; // Standard plan
} elseif ($selectedPlan == '12') {
    $unitAmount = 7999; // Premium plan
} else {
    // Handle the case where an invalid plan is selected
    echo "Invalid plan selected.";
    exit;
}

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/HDMovies-app/main/success.php",
    "cancel_url" => "http://localhost/HDMovies-app/main/subscription.php",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "USD",
                "unit_amount" => $unitAmount,
                "product_data" => [
                    "name" => "$selectedPlan months"
                ]
            ]
        ]
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);
?>
