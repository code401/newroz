<?php
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
    

  

  

    $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge,preorder)
VALUES ('$name', '$orderid', '$mobileno', '$address' ,'$charge',1)";

if ($conn->query($sql) === TRUE) {
    echo "pre record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }


}

//multi
if($_REQUEST['type']==2){

    $namelist=$_REQUEST['name'];
    $namearray = explode (",", $namelist);
    
    for($i=0;$i<count($namearray);$i++){

         


        $orderid=$orderid.$i;
        $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge,preorder)
        VALUES ('$namearray[$i]', '$orderid', '$mobileno', '$address' ,'$charge',1)";
        
        if ($conn->query($sql) === TRUE) {


            //invoice
            echo "multi pre record created successfully";

          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }


    }
   


}



}



$conn->close();





?>