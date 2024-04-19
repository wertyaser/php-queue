<?php
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'queue_db';

$conn = new mysqli($server, $username, $password, $dbname);

if (!$conn) {
    echo "Connection failed!";
}