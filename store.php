<?php



//http://localhost/newroz/task1/store.php?name='hi'&stock=1&price=3&weight=2

//http://localhost/newroz/task1/store.php?name='hi'&stockupdate=1

isset($_REQUEST['name'])?$product_name=$_REQUEST['name']:'';
isset($_REQUEST['stock'])?$product_stock=$_REQUEST['stock']:'';
isset($_REQUEST['price'])?$product_price=$_REQUEST['price']:'';
isset($_REQUEST['weight'])?$product_weight=$_REQUEST['weight']:'';
isset($_REQUEST['stockupdate'])?$product_stock_update=$_REQUEST['stockupdate']:'';


$conn = new mysqli("localhost", "root", "", "newroz_task");



if(isset($product_stock_update)){

    $sql = "UPDATE product SET stock=stock+$product_stock_update WHERE name=$product_name";

    if ($conn->query($sql) === TRUE) {

      $output='updated successfully';
    http_response_code(200);
    echo json_encode($output);

      
    } else {
     // echo "Error updating record: " . $conn->error;
    }


}else{

    $result = $conn->query("SELECT name FROM product WHERE name=$product_name");

    if ($result->num_rows > 0) {
 
        echo 'y';
    
    } else{
  
    $sql = "INSERT INTO product (name, stock, price,weight)
    VALUES ($product_name, $product_stock, $product_price,$product_weight)";
    
    if ($conn->query($sql) === TRUE) {
      $output='data added successfully';
    http_response_code(200);
    echo json_encode($output);
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
    
}



$conn->close();



?>