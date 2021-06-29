<?php


//product order
//type 1 is for single and type 2 for multiple product order

//signle product order
//http://localhost/newroz/task2/order.php?mobileno=0131364334&address=farmgate,dhaka&name=chair&type=1

//multiple product order
//http://localhost/newroz/task2/order.php?mobileno=01314867867&address=rajshahi&name=chair,sofa&type=2

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

  //generate unique order id
$orderid=substr(md5(rand(1,10000)),0,6).$orderid;



if(isset($_REQUEST['type'])){

  //single product order
if($_REQUEST['type']==1){

    $name=$_REQUEST['name'];
    

    $sql = "SELECT stock FROM product WHERE name='$name'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
     
      while($row = $result->fetch_assoc()) {

         if($row['stock']>0){

           //stock  available

           $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge) VALUES ('$name', '$orderid', '$mobileno', '$address' ,'$charge')";

           if ($conn->query($sql) === TRUE) {
           
              $response=array('orderid'=>$orderid,'productname'=>$name,'mobileno'=>$mobileno,'address'=>$address,'deliverycharge'=>$charge);
              http_response_code(200);

              //invoice
              echo json_encode($response);
           
             } else {
           
               echo "Error: " . $sql . "<br>" . $conn->error;
           
             }

         }
      }
    } else {

        //stock  not available
 
    }

  

  


}

//multiple product order
if($_REQUEST['type']==2){


  

  //for multiple product,request string into product array list
    $namelist=$_REQUEST['name'];
    $namearray = explode (",", $namelist);
    
    for($i=0;$i<count($namearray);$i++){

        $sql = "SELECT stock FROM product WHERE name='$namearray[$i]'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
             if($row['stock']>0){
    
              $orderid=$orderid.$i;

              $sql = "INSERT INTO product_order (name,orderid, mobile_no, address , charge) VALUES ('$namearray[$i]', '$orderid', '$mobileno', '$address' ,'$charge')";
              
              if ($conn->query($sql) === TRUE) {   
                
                $response=array('orderid'=>$orderid,'productname'=>$namearray[$i],'mobileno'=>$mobileno,'address'=>$address,'deliverycharge'=>$charge);
            
                //invoice
                echo json_encode($response);
                echo '<br/>';
    

                } else {
      
                  echo "Error: " . $sql . "<br>" . $conn->error;
      
                }

             }
             else {

              //stock not available

            }
          }
        } 

       


    }
   
   

}



}



$conn->close();





?>