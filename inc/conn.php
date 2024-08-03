<?php 
$conn = mysqli_connect('localhost:3307','root','','projet_pweb'); 
if (!$conn) {
    echo 'ERROR:' . mysqli_connect_error();
}