<?php


//http://localhost/newroz/task2/order.php?mobileno=02&address=dhaka&name=k&type=1
//http://localhost/newroz/task2/order.php?mobileno=02&address=dhaka&name=k,j&type=2

isset($_REQUEST['mobileno'])?$mobileno=$_REQUEST['mobileno']:'';
isset($_REQUEST['address'])?$address=$_REQUEST['address']:'';
isset($_REQUEST['name'])?$productname=$_REQUEST['name']:'';
if(isset($_REQUEST['address'])){
    


if(strpos(strtolower($address),'dhaka')>-1){

    $charge=60;
  

}
else{

    $charge=100;

}

}


$conn = new mysqli("localhost", "root", "", "newroz_task");

$sql = "SELECT id FROM product_order ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $orderid=$row['id'];

    }
   
  } else {
    $orderid=0;

  }

$orderid=substr(md5(rand(1,10000)),0,6).$orderid;



if(isset($_REQUEST['type'])){
    //single
if($_REQUEST['type']==1){

    $name=$_REQUEST['name'];
    

    $sql = "SELECT stock FROM product WHERE name='$name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {
         if($row['stock']>0){

           // echo 'stock  available';
         }
      }
    } else {
        echo 'stock  not available';
  exit();
    }

  

    $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge)
VALUES ('$name', '$orderid', '$mobileno', '$address' ,'$charge')";

if ($conn->query($sql) === TRUE) {
    echo "s record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }


}

//multi
if($_REQUEST['type']==2){

    $namelist=$_REQUEST['name'];
    $namearray = explode (",", $namelist);
    
    for($i=0;$i<count($namearray);$i++){

        $sql = "SELECT stock FROM product WHERE name='$namearray[$i]'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
             if($row['stock']>0){
    
               // echo 'stock  available';
             }
          }
        } else {
            echo 'stock  not available';
      exit();
        }
    


        $orderid=$orderid.$i;
        $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge)
        VALUES ('$namearray[$i]', '$orderid', '$mobileno', '$address' ,'$charge')";
        
        if ($conn->query($sql) === TRUE) {


            //invoice
            //echo 
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }


    }
   


}



}



$conn->close();





?>