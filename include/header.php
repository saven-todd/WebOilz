<?php 
include_once 'db.php';
if(isset($_SESSION['ID'])){    
    $ID = $_SESSION['ID'];
    $name = $_SESSION['name'];
    $level = $_SESSION['status'];
    $fbid = $_SESSION['fbid'];
}

$action = isset($_GET['a']) ? $_GET['a'] : "";
$itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
if(isset($_SESSION['qty'])){
$meQty = 0;
foreach($_SESSION['qty'] as $meItem){
$meQty = is_numeric($meQty) + is_numeric($meItem);
}
} else {
$meQty=0;
}
if (isset($_SESSION['cart']) and $itemCount > 0)
{
$itemIds = "";
foreach ($_SESSION['cart'] as $itemId){
$itemIds = $itemIds . $itemId . ",";
}
$inputItems = rtrim($itemIds, ",");

$query_product = "SELECT * FROM tbl_product as p
INNER JOIN tbl_type as t ON p.type_id = t.type_id where p_id in ({$inputItems}) ;";
$meQuery = mysqli_query($con,$query_product) or die ("Error in query: $query_product " . $con->error);
$meCount = mysqli_num_rows($meQuery);
// echo($query_product);
// exit()

} else
{
$meCount = 0;
}
?>
<title>ญวนใจขนมปัง ปัง By Aomsin</title>

<!-- CSS + Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="include/style.css">

<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JS / Script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--แถบโลโก้-->
<?php 
    if(!isset($_SESSION['status'])){ 
?>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="col-2">
            <a href="index.php"> <img src="IMG/logo.png" width="100" hight="100" alt=""></a>
        </div>

        <div class="col-6">

            <!-- Search form -->
            <form class="form-inline d-flex justify-content-center md-form form-sm active-pink active-pink-2 mt-2">
                <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="ค้นหาสินค้า"
                    aria-label="Search">
                <button type="submit" class="btn btn-outline-warning btn-rounded btn-sm my-0"><img src="IMG/search.png"
                        width="20" hight="20" alt=""></button>
            </form>

        </div>

        <div align="right" class="col-4">
            <a class="navbar-brand nav-link" href="#">
                <font size="3"> <img src="IMG/pin.png" alt="check"> ที่ตั้งร้าน</font>
            </a>
            <a class="navbar-brand" href="login.php">
                <font size="3"> | <img src="IMG/shopping-list.png" alt="check"> เข้าสู่ระบบ</font>
            </a>
        </div>
    </nav>
</div>
<!--Menu-->
<div class="head2">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="promotion.php" style=" width: max-content;">
                                    <font color="#FFFFFF" size="3"> โปรโมชั่น </font>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#" style=" width: max-content;">
                                    <font color="#FFFFFF" size="3"> ชุดสุดคุ้ม </font>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="howtoorder.php" style=" width: max-content;">
                                    <font color="#FFFFFF" size="3"> วิธีการสั่งซื้อสินค้า </font>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="howtopay.php" style=" width: max-content;">
                                    <font color="#FFFFFF" size="3"> วิธีการชำระเงิน </font>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#" style=" width: max-content;">
                                    <font color="#FFFFFF" size="3"> เมนูเพิ่มเติม </font>
                                </a>
                            </li> -->
                        </ul>
                    </div>

                </nav>
            </div>
            <div align="right" class="col-6">
            </div>
        </div>
    </div>
</div>
<?php } else {?>

<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="col-2">
            <a href="shopping.php"> <img src="IMG/logo.png" width="100" hight="100" alt=""></a>
        </div>

        <div class="col-6">

            <!-- Search form -->
            <form class="form-inline d-flex justify-content-center md-form form-sm active-pink active-pink-2 mt-2">
                <input class="form-control form-control-sm ml-3 w-75" type="text" placeholder="ค้นหาสินค้า"
                    aria-label="Search">
                <button type="submit" class="btn btn-outline-warning btn-rounded btn-sm my-0"><img src="IMG/search.png"
                        width="20" hight="20" alt=""></button>
            </form>

        </div>

        <div align="right" class="col-4">
            <a class="navbar-brand nav-link" href="#">
                <font size="3"> <img src="IMG/pin.png" alt="check"> ที่ตั้งร้าน </font>
            </a>
            <a class="navbar-brand" href="dashboard.php">
                <font size="3"> | <img src="IMG/shopping-list.png" alt="check"> <?php echo $name; ?></font>
            </a>

        </div>
    </nav>
</div>
<!--Menu-->
<div class="head2">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                        aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="auth_promotion.php">
                                    <font color="#FFFFFF" size="3"> โปรโมชั่น </font>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <font color="#FFFFFF" size="3"> ชุดสุดคุ้ม </font>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a class="nav-link" href="auth_howtoorder.php">
                                    <font color="#FFFFFF" size="3"> วิธีการสั่งซื้อสินค้า </font>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="auth_howtopay.php">
                                    <font color="#FFFFFF" size="3"> วิธีการชำระเงิน </font>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <font color="#FFFFFF" size="3"> เมนูเพิ่มเติม </font>
                                </a>
                            </li> -->
                        </ul>
                    </div>

                </nav>
            </div>

            <div align="right" class="col-6">
                <img src="IMG/bag1.png" width="60" hight="40" alt="">
                <label for=""><?=$meCount;?></label>
            </div>
        </div>
    </div>
</div>
<?php } ?>