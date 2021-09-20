<?php 
/*
* @ Purpose: Check customer exists or not(With API).
* @ Purpose: Check customer phone number exists or not(With API).
*/

include 'prettyfizbiz_config.php';

header("Access-Control-Allow-Origin: *");


if(isset($_GET))
{

    
	 $add_cus = order();
	

}


function order()
{
    $product_id =trim($_GET['pid']);
    $start_date = trim($_GET['g_start_date']);
    $end_date = trim($_GET['g_end_date']);
$url= API_URL ."admin/api/2021-01/orders.json?updated_at_min=".$start_date."&".$end_date;


$total = 0; 
 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result=curl_exec($ch);
curl_close($ch);
$responce=json_decode($result);
$array = get_object_vars($responce);

$length = count($array['orders']);

// echo $length."<br>";
for( $i = 0; $i < $length; $i++){
    $order = get_object_vars($array['orders'][$i]);

    $order_id = $order['id'];
    // echo "order id : ".$order_id."<br>";

    $items = $order['line_items'];
    $item_l = count($items);
    // echo "item : ".$item_l." <br>";

 
    for( $j = 0; $j < $item_l; $j++){
        $item = get_object_vars($order['line_items'][$j]);
        $p_id = $item['product_id'];

        if($p_id == $product_id){
        $quantity = $item['quantity'];
        // echo "quantity ".$quantity ."<br>";
        $total = $total + $quantity ;
    }
       
        
    }
 
    
}
echo $total;
}
?>