<?php 
    include "api/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Task-SaasLabs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <style>
    button{
        position:fixed;
        top:2%;
        right:2%;
    }
    h2{
        text-align:center;
        text-decoration:underline;
    }
    .clickable{
        cursor:pointer;
    }

    .customer{
        display:none;
    }
  </style>
</head>
<body>

    <div class="container">
        <button id="get_customers" type="button" class="btn btn-primary">Refresh</button>
        <div class="row">
            <div class="col-md-12">
                <h2>CUSTOMERS</h2>
                <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">
                        <thead>   
                        <th>Id</th>    
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Sms Status</th>
                        </thead>
                        <tbody>
                        
                        <?php 
                            $limit = 5;  
                            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
                            $start_from = ($page-1) * $limit; 
                            $sql = "SELECT customers.id, customers.shopify_id, customers.first_name, customers.last_name, customers.email, customers.phone, customers.sms_status, addresses.address1 
                            FROM customers INNER JOIN addresses ON customers.id = addresses.customer_id LIMIT $start_from, $limit";

                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                $i=1;
                                while($row = $result->fetch_assoc()) {
                                    $sms_status = $row['sms_status'];
                                    
                                    if($sms_status){
                                        echo "<tr>";
                                    }
                                    else{
                                        echo "<tr data-toggle='collapse' data-target='#accordion_".$i."' class='clickable'>";
                                    }
                                    echo "<td>".$row['shopify_id']."</td>
                                    <td>".$row['first_name']."</td>
                                    <td>".$row["last_name"]."</td>
                                    <td>".$row["address1"]."</td>
                                    <td>".$row["email"]."</td>
                                    <td>".$row["phone"]."</td>";
                                    if($sms_status){
                                    echo "<td>Sent</td>";
                                    }
                                    else{
                                        echo "<td>Not sent</td>";
                                    }
                                    echo "</tr>
                                    <tr>
                                        <td colspan='7'>
                                            <div id='accordion_".$i."' class='collapse'>
                                                <h4> Select any one message and send to ".$row['first_name']." ".$row['last_name']." </h4> 
                                                <form>
                                                    <span class='customer'>".$row['id']."</span>
                                                    <div class='radio'>
                                                    <label><input type='radio' name='sms' checked>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</label>
                                                    </div>
                                                    <div class='radio'>
                                                    <label><input type='radio' name='sms'>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</label>
                                                    </div>
                                                    <div class='radio'>
                                                    <label><input type='radio' name='sms'>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</label>
                                                    </div>
                                                    <buton type='submit' class='btn btn-info sms-btn'>Send</>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>";
                                    $i++;
                                }
                            } 
                        ?>

                        </tbody>
                    </table>
                    <div class="clearfix"></div>
                    <ul class="pagination pull-right">
                    <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>

                    <?php  
                        $sql = "SELECT COUNT(id) FROM customers";  
                        $rs_result = $conn->query($sql); 
                        $row = $rs_result->fetch_assoc();
                        $total_records = $row["COUNT(id)"];
                        $total_pages = ceil($total_records/$limit);  
                        for ($i=1; $i<= $total_pages; $i++) {  
                                    echo "<li><a href='index.php?page=".$i."'>".$i."</a></li>";  
                        };  
                    ?>

                    <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        
    </script>
</body>
</html>
