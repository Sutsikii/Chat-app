<?php
    $conn = mysqli_connect("localhost", "root", "", "qpc-2");
    if(!$conn)
    {
        echo "Bdd non connectée" . mysqli_connect_error();
    }
?>