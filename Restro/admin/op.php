<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

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
    </div><!-- For more projects: Visit codeastro.com  -->
    <!-- Page content -->
    <div class="container-fluid mt--8">

  
      <!-- Table -->
      <div class="row">
          <div class="col">
              <div class="card shadow">
              <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="card-header border-0">
              <p>Select On Any Product To Make An Order</p>
              <button name="dis" class="btn btn-success">show</button>
            </div></form>
            <div class="table-responsive">
                <?php
                // if(isset($_POST['$dis'])){
                $link=mysqli_connect("localhost","root","");
                $qry="SELECT * FROM  `rposystem`.`rpos_products`";
                $resultSet=mysqli_query($link,$qry);
            $table=<<<Tab
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col"><b>Product Code</b></th>
                <th scope="col"><b>Name</b></th>
                <th scope="col"><b>Price</b></th>
                <th style="text-align: center;" scope="col"><b>Action</b></th>
              </tr>
            </thead><!-- For more projects: Visit codeastro.com  -->
            <tbody>

Tab ;




              
while ($row=mysqli_fetch_assoc($resultSet)) {
    $re = "SELECT COUNT(*) FROM `rpos_products`";
    $stmt = $mysqli->prepare($re);
    $stmt->execute();
    $res = $stmt->get_result();
        $r="<tr><td>$row[prod_code]</td><td>$row[prod_name]</td><td>$row[prod_price]</td> <td><input type='number'></td> </tr>";
    $table.=$r;
    }
    
$table.= "</tbody></table>";
                    
echo $table;    
                  
// }
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
<!-- For more projects: Visit codeastro.com  -->
</html>