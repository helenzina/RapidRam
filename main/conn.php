<?php

    $mysqli= new mysqli('localhost', 'root', '', 'ram_db');
                        
    if ($mysqli->connect_errno) {
        die("Connection error: " . $mysqli->connect_error);
    }

    return $mysqli;
?>