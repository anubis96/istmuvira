<?php

$conn = mysqli_connect("localhost", "root", "", "recherches");

if (!$conn) {
    echo "Connection Failed";
}