<?php
include "config.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = test_input($_POST["id"]);    
}
    $sql = "UPDATE customers SET sms_status=true WHERE id=$id";
    if ($conn->query($sql)===true) {
        echo "Message has been sent to the customer";
    } 
    else{
        //echo "Error: " . $sql . "<br>" . $conn->error;
        echo "something went wrong please try again";
    }
     $conn->close();
?>