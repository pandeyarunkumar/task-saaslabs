<?php
include "config.php";

$url = "https://9236b3bc0471ef82a91bd66f0470633a:2988eea3ec6324c8f490fc2c97bdb340@cyberworldhub.myshopify.com/admin/api/2019-04/customers.json";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);

$decoded = json_decode($result, true);
$customers = $decoded['customers'];

foreach($customers as $customer){
    $sql = "INSERT INTO customers (shopify_id, email, accepts_marketing, created_at, updated_at, first_name, last_name, 
    orders_count, state, total_spent, last_order_id, note, verified_email, multipass_identifier, tax_exempt, phone, tags, 
    last_order_name, currency, accepts_marketing_updated_at, marketing_opt_in_level, admin_graphql_api_id)

    VALUES ('".$customer["id"]."','".$customer["email"]."', '".$customer["accepts_marketing"]."', '".$customer["created_at"]."', 
    '".$customer["updated_at"]."', '".$customer["first_name"]."', '".$customer["last_name"]."', '".$customer["orders_count"]."', 
    '".$customer["state"]."', '".$customer["total_spent"]."', '".$customer["last_order_id"]."', '".$customer["note"]."', 
    '".$customer["verified_email"]."', '".$customer["multipass_identifier"]."', '".$customer["tax_exempt"]."', 
    '".$customer["phone"]."', '".$customer["tags"]."', '".$customer["last_order_name"]."', '".$customer["currency"]."', 
    '".$customer["accepts_marketing_updated_at"]."', '".$customer["marketing_opt_in_level"]."', 
    '".$customer["admin_graphql_api_id"]."')
    
    ON DUPLICATE KEY UPDATE email = '".$customer["email"]."', accepts_marketing = '".$customer["accepts_marketing"]."', 
    created_at = '".$customer["created_at"]."', updated_at = '".$customer["updated_at"]."', first_name = '".$customer["first_name"]."',
    last_name = '".$customer["last_name"]."', orders_count = '".$customer["orders_count"]."', state = '".$customer["state"]."', 
    total_spent = '".$customer["total_spent"]."', last_order_id = '".$customer["last_order_id"]."', note = '".$customer["note"]."', 
    verified_email = '".$customer["verified_email"]."', multipass_identifier = '".$customer["multipass_identifier"]."',
    tax_exempt = '".$customer["tax_exempt"]."', phone = '".$customer["phone"]."', tags = '".$customer["tags"]."',
    last_order_name = '".$customer["last_order_name"]."', currency = '".$customer["currency"]."', accepts_marketing_updated_at = '".$customer["accepts_marketing_updated_at"]."',
    marketing_opt_in_level = '".$customer["marketing_opt_in_level"]."', admin_graphql_api_id = '".$customer["admin_graphql_api_id"]."'"; 

    if ($conn->query($sql) === TRUE){
        $customer_id = $conn->insert_id;
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if($customer_id){
        $addresses = $customer['addresses'];
    
        foreach($addresses as $address){
            $sql = "INSERT INTO addresses (customer_id, first_name, last_name, company, address1, address2, city, province, 
            country, zip, phone, name, country_code, country_name, province_code)

            VALUES ('$customer_id', '".$address["first_name"]."', '".$address["last_name"]."', '".$address["company"]."', 
            '".$address["address1"]."', '".$address["address2"]."', '".$address["city"]."', '".$address["province"]."', 
            '".$address["country"]."', '".$address["zip"]."', '".$address["phone"]."', '".$address["name"]."', 
            '".$address["country_code"]."', '".$address["country_name"]."', '".$address["province_code"]."')";
        
            if ($conn->query($sql) === TRUE){
                echo "Data inserted successfully";
            }
            else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
    echo "Refreshed";
    $conn->close();

?>
