<?php






$conn = new mysqli("localhost", "root", "", "newroz_task");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if(isset($_REQUEST['list'])&&isset($_REQUEST['list'])=='all'){


$sql = "SELECT * FROM product_order";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        echo $row['status'];
    }
} else {
    echo "0 results";
}


}

if(isset($_REQUEST['status']) && isset($_REQUEST['orderid'])){

    $status=$_REQUEST['status'];
    $orderid=$_REQUEST['orderid'];

    $sql = "UPDATE product_order SET status='$status' WHERE orderid='$orderid'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    }


    
if(isset($_REQUEST['stockupdate']) && isset($_REQUEST['orderid'])){

    $stockupdate=$_REQUEST['stockupdate'];
    $orderid=$_REQUEST['orderid'];


    $sql = "SELECT name FROM product_order WHERE orderid='$orderid' LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
        
        $name=$row['name'];

      }
    }
    else {
       
  
    }

    $sql = "UPDATE product SET stock=stock+$stockupdate WHERE name='$name'";

    if ($conn->query($sql) === TRUE) {
      echo "Record updated successfully";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    }



$conn->close();
?>