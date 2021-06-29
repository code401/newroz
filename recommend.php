<?php

//product recommendation
//http://localhost/newroz/task5/recommend.php?mobileno=01314465656&address=dhaka&name=sofa&type=1&price=50

isset($_REQUEST['mobileno'])?$mobileno=$_REQUEST['mobileno']:'';
isset($_REQUEST['address'])?$address=$_REQUEST['address']:'';
isset($_REQUEST['name'])?$productname=$_REQUEST['name']:'';
isset($_REQUEST['price'])?$price=$_REQUEST['price']:'';


$conn = new mysqli("localhost", "root", "", "newroz_task");


if(isset($_REQUEST['type'])){
  

    //single product order
if($_REQUEST['type']==1){
 

    $name=$_REQUEST['name'];
    

    $sql = "SELECT stock FROM product WHERE name='$name' AND stock>0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

      //order product available

    } else {        

      //product recommendation
        
      //recommend product if price is within 100 tk more,so product are in the recommend list

      $newprice=$price+100;

        $sql = "SELECT name FROM product WHERE price<$newprice AND stock>0";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
         
          while($row = $result->fetch_assoc()) {
           
          //here,if anybody order for swan sofa,if this type of sofa is not available but another company sofa is available,so it is highly recommended

            if(similar_text($name,$row['name'])>3){
              $response=array('recommendproduct'=> $row['name']);
              echo json_encode($response);
        
           }
          }
        } else {

       

       }
      
      }    
        }}



$conn->close();





?>