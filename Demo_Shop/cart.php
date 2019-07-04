<?php

	
//connection to database

	
  session_start();

	
  $connect = mysqli_connect('localhost','root','','test');

	

	
    if(isset($_POST["add_to_cart"]))

	
    {

	
      if(isset($_SESSION["shopping_cart"]))

	
      {

	
        $item_array_id = array($_SESSION["shopping_cart"], "item_id");

	
        if(!in_array($_GET["id"], $item_array_id))

	
        {

	
          $count = count($_SESSION["shopping_cart"]);

	
    //get all item detail

	
            $item_array = array(

	
                      'item_id'       =>   $_GET["id"],

	
                      'product_img'   =>   $_POST["hidden_image"],

	
                      'item_name'     =>   $_POST["hidden_name"],

	
                      'item_price'    =>   $_POST['hidden_price'],

	
                      'item_quantity' =>   $_POST["quantity"]

	

	
            );

	
            $_SESSION["shopping_cart"][$count] = $item_array;

	
        }

	
        else

	
        {

	
          //product added then this block 

	
          echo '<script>alert("Item allready added ")</script>';

	
          echo '<script>window.location = "cart.php"</script>';

	
        }

	
      }

	
      else

	
      {

	
        //cart is empty excute this block

	
         $item_array = array(

	
                      'item_id'       =>   $_GET["id"],

	
                      'product_img'   =>   $_POST["hidden_image"],

	
                      'item_name'     =>   $_POST["hidden_name"],

	
                      'item_price'    =>   $_POST['hidden_price'],

	
                      'item_quantity' =>   $_POST["quantity"]

	

	
            );

	
           $_SESSION["shopping_cart"][0] = $item_array;

	
      }

	
    }

	
//Remove item in cart 

	
    if(isset($_GET["action"]))

	
    {

	
      if($_GET["action"] == "delete")

	
      {

	
        foreach($_SESSION["shopping_cart"] as $key=>$value)

	
            {

	
              if($value["item_id"] == $_GET["id"])

	
              {

	
                unset($_SESSION["shopping_cart"][$key]);

	
                echo '<script>alert("Item removed")</script>';

	
                echo '<script>window.location="cart.php</script>';

	
              }

	
            }

	
      }

	
    }

	

	

	

	

	

	
?>

	
<!DOCTYPE html>  

	
 <html>  

	
      <head>  

	
           <title>PHP Webslesson Tutorial | Simple PHP Mysql Shopping Cart</title>  

	
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

	
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  

	
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="css/index.css"> 

	
      </head>  

	
      <body>  

	
           <br />  
           
           <div style="color: black; font-size: 15px;">
          <p>
              <a href="home.html"><p><span class="glyphicon glyphicon-circle-arrow-left"></span> Back to Home Page</p></a>
           </p>
       </div>
	
           <div class="container" style="width:1000px;">  

	
                <h1>My Cart</h1><br />  

	
                  <?php

	
                    $qury = "SELECT * FROM cart ORDER BY id ASC";

	
                    $result = mysqli_query($connect,$qury);

	
                    if(mysqli_num_rows($result) >0)

	
                    {

	
                      while($row = mysqli_fetch_array($result))

	
                      {

	

	
                  ?>

	
                <div class="col-md-6">  

	
                     <form method="post" action="cart.php?action=add&id=<?php echo $row["id"];?>">  

	
                          <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">  

	
                               <img src="images/<?php echo $row['image'];?>" style="width:150px; height:200px" /><br />  

	
                               <h3 class="text-info"><?php echo $row['name'];?></h3>  

	
                               <h3 class="text-danger">Rs.<?php echo $row['price'];?></h3>  

	
                               <input type="text" name="quantity" class="form-control" value="1" />

	
                            <input type="hidden" name="hidden_name" value="<?php echo $row['name'] ?>" />

	
                           <input type="hidden" name="hidden_image" value="<?php echo $row['image'];?>">

	
                            <input type="hidden" name="hidden_price" value="<?php echo $row['price'];?>">

	

	

	
                               <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />  

	
                          </div>  

	
                     </form>  

	
                </div>  

	
                  <?php } } ?>

	
                <div style="clear:both"></div>  

	
                <br />  

	
                <h3>Order Details</h3>  

	
                <div class="table-responsive">  

	
                     <table class="table table-bordered">  

	
                          <tr> 

	
                              <th>product image</th> 

	
                               <th width="40%">Item Name</th>  

	
                               <th width="10%">Quantity</th>  

	
                               <th width="20%">Price</th>  

	
                               <th width="15%">Total</th>  

	
                               <th width="5%">Action</th>  

	
                          </tr>  

	
                             <?php 

	
                           if(!empty($_SESSION["shopping_cart"]))

	
                           {

	
                            $total = 0;

	
                            foreach($_SESSION["shopping_cart"] as $key => $value)

	
                           {

	
                            

	

	
                             ?>

	
                          <tr> 

	
                               <td><img src="images/<?php echo $value['product_img'];?>" style="width: 90px; height:110px"></td>

	
                             

	
                               <td><?php echo $value['item_name'];?></td>  

	
                               <td><?php echo $value['item_quantity']; ?></td>  

	
                               <td>Rs.<?php echo $value['item_price'];?></td>  

	
                               <td>Rs.<?php echo number_format($value["item_quantity"] * $value["item_price"],2);?></td>  

	
                               <td><a href="cart.php?action=delete&id=<?php  echo $value['item_id'];?>"><span class="btn btn-danger">Remove</span></a></td>  

	
                          </tr>  

	
                          <?php $total = $total + ($value["item_quantity"] * $value['item_price']);

	
                        }

	
                        ?>

	
                           

	
                          <tr>  

	
                               <td colspan="3" align="right">Total</td>  

	
                               <td align="right">Rs.<?php echo number_format($total);?></td>  

	
                               <td></td>  

	
                          </tr> 

	
                          <?php } ?> 

	
                           

	
                     </table>  
                     
                     
                    

	
                </div>  
                
               <a href="payment.html"> <button class="btn btn-danger" style="font-size:15px; float:right">Pay Now</button> </a>

	
           </div>  

	
           <br />  

	
      </body>  

	
 </html>
 

  
   
    
     
      
       
        
         
          
           
            
  
