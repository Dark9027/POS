
<?php
               
                
                ?>

<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
$ret = "SELECT * FROM  rpos_products ";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
$c1=mysqli_num_rows($res);
// echo $c1;




for ($i=1; $i<=$c1; $i++) {
  $a=$_GET['ck'.(string)$i];
  if($a!=0){
    $e=$i-1;
    $re="UPDATE `rpos_products` SET `quantity`='$a' WHERE prod_id = ( SELECT prod_id FROM `rpos_products` LIMIT $e,1 );";
    $stm = $mysqli->prepare($re);
$stm->execute();
$re = $stm->get_result();
// $prod = $res->fetch_object();
// $prod->quantity;
  }
  else{
    $e=$i-1;
    $re="UPDATE `rpos_products` SET `quantity`='0' WHERE prod_id = ( SELECT prod_id FROM `rpos_products` LIMIT $e,1 );";
    $stm = $mysqli->prepare($re);
$stm->execute();
$re = $stm->get_result();
  }
}


if (isset($_POST['make'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["order_code"]) || empty($_POST["customer_name"]) || empty($_GET['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $ret = "SELECT SUM(quantity) AS total
                FROM `rpos_products`;";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute();
                $res = $stmt->get_result();
                $pro = $res->fetch_object();
               
    $order_id = $_POST['order_id'];
    $order_code  = $_POST['order_code'];
    $customer_id = $_POST['customer_number'];
    $customer_name = $_POST['customer_name'];
    // $prod_id  = "23s";
    // $prod_name = "xyz";
    $prod_price = $_POST['price'];
    $prod_qty = $pro->total;

    //Insert Captured information to a database table
    $postQuery = "INSERT INTO `rpos_add` (`order_id`, `order_code`, `customer_number`, `customer_name`, `prod_price`, `prod_qty`) VALUES ('$order_id', '$order_code', '$customer_id', '$customer_name', '$prod_price', '$prod_qty');";
    // $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    // $rc = $postStmt->bind_param('ssssssss', $prod_qty, $order_id, $order_code, $customer_number, $customer_name, $prod_id, $prod_name, $prod_price);
    $postStmt = $mysqli->prepare($postQuery);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Order Submitted" && header("refresh:1; url=payments.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
    <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->

     
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <h3>Please Fill All Fields</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="form-row">

                  <div class="col-md-4">
                    <label>Customer Name</label>



                    <input type="text" name="customer_name" class="form-control"  value="" onChange="getCustomer(this.value)">

                    <input type="hidden" name="order_id" value="<?php echo $orderid; ?>" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label>Total Price (INR)</label>
                    <input type="text" name="price" readonly id="q" class="form-control" value="<?php
                $ret = "SELECT SUM(prod_price * quantity) AS total
                FROM `rpos_products`;";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute();
                $res = $stmt->get_result();
                $pro = $res->fetch_object();
                echo $pro->total;
                ?>">
                  </div>

                  <div class="col-md-4">
                    <label>Order Code</label>
                    <input type="text" name="order_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                  <div class="col-md-4">
                    <label>Customer Number</label>
                    <input type="text" name="customer_number" class="form-control">
                  </div>
                  <!-- <label>Customer Number</label> -->
                  <div style="margin-top:3%; display:flex; justify-content:center; align-items:center;" class="col-md-4">
                    <input type="submit" name="make" class="btn btn-success">
                  </div>
                </div>
                <hr>               
                
              </form>
              <?php
              
              
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>