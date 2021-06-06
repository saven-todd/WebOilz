<?php
    require_once __DIR__ .'../../db.php';    
    require_once 'function.inc.php';
    require_once __DIR__ .'../../vendor/autoload.php';

    $date = date('d');
    $date2 = date('d',strtotime("- dayss"));
    $date3 = date('d',strtotime("-2 days"));
    $date4 = date('d',strtotime("-3 days"));
    $date5 = date('d',strtotime("-4 days"));
    $date6 = date('d',strtotime("-5 days"));
    $date7 = date('d',strtotime("-6 days"));

    $__date1 = date('Y-m-d h:i:s');
    $__date2 = date('Y-m-d 00:00:00',strtotime('-7 days'));

    $sql = "SELECT * FROM v_receipt WHERE OrderDate > '$__date2';";
    $result = mysqli_query($con,$sql);
    $data = mysqli_fetch_assoc($result);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานคำสั่งซื้อ</title>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css">

    <style>
    h1 {
        margin-top: 1em;
    }

    table {
        margin-bottom: 2em;
        background-color: #fff;
    }

    .order {
        width: 60px;
        border: 1px solid #dee2e6;
    }

    .date {
        max-width: 200px;
        border: 1px solid #dee2e6;
    }

    .product {
        max-width: 120px;
        border: 1px solid #dee2e6;
    }

    .qty {
        max-width: 50px;
        border: 1px solid #dee2e6;
    }

    .price {
        max-width: 100px;
        border: 1px solid #dee2e6;
    }

    .status {
        max-width: 180px;
        border: 1px solid #dee2e6;
    }

    .result {
        text-align: right;
    }
    </style>

    <script>
    function printToPDF() {
        printJS({
            printable: "data-from",
            type: "html",
            targetStyles: ['*'],
            style: `td { padding:10px; } 
                    .order {
                        width: 60px;
                        border: 1px solid #dee2e6;
                    }

                    .date {
                        max-width: 200px;
                        border: 1px solid #dee2e6;
                    }

                    .product {
                        max-width: 120px;
                        border: 1px solid #dee2e6;
                    }

                    .qty {
                        max-width: 50px;
                        border: 1px solid #dee2e6;
                    }

                    .price {
                        max-width: 100px;
                        border: 1px solid #dee2e6;
                    }

                    .status {
                        max-width: 180px;
                        border: 1px solid #dee2e6;
                    }
                                    
                    .result {
                        text-align: right;
                    }`
        });
    }

    document.getElementById("pdf-button").addEventListener("click", printToPDF);
    </script>
</head>

<body id="body">
    ดาวโหลดรายงานในรูปแบบ PDF <button id="pdf-button" class="btn btn-primary btn-lg">คลิก</button>
    <hr>
    <div id="data-from">
        <h1 style="text-align: center;">เดือน <?=DateThai(date('Y-m-d')); ?></h1>

        <canvas id="myChart" width="400" height="200"></canvas> <!-- Graph -->

        <h1>วันที่ <?=date('d / m / Y')?></h1>
        <table id="myTable" class="table123">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                $n1 = 0;
                $n2 = 0;
                $n3 = 0;
                $n4 = 0;
                $n5 = 0;
                $n6 = 0;
                $n7 = 0;
                $total1 = 0;
                $total2 = 0;
                $total3 = 0;
                $total4 = 0;
                $total5 = 0;
                $total6 = 0;
                $total7 = 0;
                $finished1 = 0;
                $finished2 = 0;
                $finished3 = 0;
                $finished4 = 0;
                $finished5 = 0;
                $finished6 = 0;
                $finished7 = 0;
                $cancel1 = 0;
                $cancel2 = 0;
                $cancel3 = 0;
                $cancel4 = 0;
                $cancel5 = 0;
                $cancel6 = 0;
                $cancel7 = 0;
                 foreach($result AS $key => $_data) {           
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00')){
                        $n1++;
                        $total1 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished1 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel1 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format($_data['Price'] * $data['Number'], 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format($_data['Price']*$data['Number'], 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    }
                } 
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n1?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total1,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished1,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel1,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished1<$cancel1){ echo "<span style='color:red;'>".number_format(($finished1-$cancel1),2)."</span>";} else { echo number_format(($finished1-$cancel1),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>

        <h1>วันที่ <?=date('d / m / Y',strtotime('-1 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-1 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00')){  
                        $n2++;
                        $total2 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished2 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel2 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    } 
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n2?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total2,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished2,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel2,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished2<$cancel2){ echo "<span style='color:red;'>".number_format(($finished2-$cancel2),2)."</span>";} else { echo number_format(($finished2-$cancel2),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
        <h1>วันที่ <?=date('d / m / Y',strtotime('-2 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-2 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00',strtotime('-1 days'))){    
                        $n3++;
                        $total3 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished3 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel3 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    } 
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n3?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total3,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished3,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel3,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished3<$cancel3){ echo "<span style='color:red;'>".number_format(($finished3-$cancel3),2)."</span>";} else { echo number_format(($finished3-$cancel3),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
        <h1>วันที่ <?=date('d / m / Y',strtotime('-3 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-3 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00',strtotime('-2 days'))){  
                        $n4++;
                        $total4 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished4 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel4 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    } 
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n4?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total4,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished4,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel4,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished4<$cancel4){ echo "<span style='color:red;'>".number_format(($finished4-$cancel4),2)."</span>";} else { echo number_format(($finished4-$cancel4),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
        <h1>วันที่ <?=date('d / m / Y',strtotime('-4 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-4 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00',strtotime('-3 days'))){  
                        $n5++;
                        $total5 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished5 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel5 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    } 
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n5?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total5,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished5,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel5,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished5<$cancel5){ echo "<span style='color:red;'>".number_format(($finished5-$cancel5),2)."</span>";} else { echo number_format(($finished5-$cancel5),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
        <h1>วันที่ <?=date('d / m / Y',strtotime('-5 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-5 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00',strtotime('-4 days'))){       
                        $n6++;
                        $total6 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished6 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel6 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    } 
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n6?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total6,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished6,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel6,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished6<$cancel6){ echo "<span style='color:red;'>".number_format(($finished6-$cancel6),2)."</span>";} else { echo number_format(($finished6-$cancel6),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
        <h1>วันที่ <?=date('d / m / Y',strtotime('-6 days'))?></h1>
        <table id="myTable">
            <thead>
                <th class="order">คำสั่งซื้อ</th>
                <th class="date">วันที่ / เวลา</th>
                <th class="product">รายการ</th>
                <th class="qty">จำนวน (ชิ้น)</th>
                <th class="price">จำนวนเงิน</th>
                <th class="status">สถานะ</th>
            </thead>
            <tbody>
                <?php
                 foreach($result AS $key => $_data) {     
                    if($_data['OrderDate'] > date('Y-m-d 00:00:00',strtotime('-6 days')) && $_data['OrderDate'] < date('Y-m-d 00:00:00',strtotime('-5 days'))){
                        $n7++;
                        $total7 += ($_data['Number'] * $_data['Price']);
                        if($_data['accept_FK']==3){
                            $finished7 += ($_data['Number'] * $_data['Price']);
                        }

                    if($_data['accept_FK'] == 0 ){                        
                        $cancel7 += ($_data['Number'] * $_data['Price']);
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="color:red; text-align:right;">-
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php
                    } else {
                ?>
                <tr>
                    <td class="order"><?php echo $_data['OrderID']; ?></td>
                    <td class="date"><?php echo $_data['OrderDate']; ?></td>
                    <td class="product" style="text-align:left;"><?php echo $_data['p_name']; ?></td>
                    <td class="qty"><?php echo $_data['Number']; ?></td>
                    <td class="price" style="text-align:right;">
                        <?php echo number_format(($_data['Number'] * $_data['Price']), 2); ?></td>
                    <td class="status"><?php echo Switchaccept_FK($_data['accept_FK']); ?></td>
                </tr>
                <?php  
                        }
                    }  
                }
                ?>
                <tr style=" background-color: #dddddd4b;">
                    <td colspan="5"> รวมคำสั่งซื้อทั้งสิ้น</td>
                    <td class="result"><?=$n7?> รายการ </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดรวม</td>
                    <td class="result"><?=number_format($total7,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดขายรวม</td>
                    <td class="result"><?=number_format($finished7,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> ยอดการยกเลิก</td>
                    <td class="result" style="color:red;">- <?=number_format($cancel7,2)?> บาท </td>
                </tr>
                <tr style="    background-color: #fff;">
                    <td colspan="5"> กำไรสุทธิ</td>
                    <td class="result">
                        <?php if($finished7<$cancel7){ echo "<span style='color:red;'>".number_format(($finished7-$cancel7),2)."</span>";} else { echo number_format(($finished7-$cancel7),2);}?>
                        บาท </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["วันที่ <?=$date7?>", "วันที่ <?=$date6?>", "วันที่ <?=$date5?>", "วันที่ <?=$date4?>",
                "วันที่ <?=$date3?>",
                "วันที่ <?=$date2?>", "วันที่ <?=$date?>"
            ],
            datasets: [{
                label: '# คำสั่งซื้อ ',
                data: [<?=$n7?>, <?=$n6?>, <?=$n5?>, <?=$n4?>, <?=$n3?>, <?=$n2?>, <?=$n1?>],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(75, 192, 192)'
                ],
                borderColor: [
                    'rgba(75, 192, 192)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        fontSize: 18,
                        labelString: 'จำนวนรายการทั้งหมด'
                    },
                    ticks: {
                        fontColor: "green",
                        stepSize: 1,
                        beginAtZero: true,
                        max: <?= (max($n7,$n6,$n5,$n4,$n3,$n2,$n1)+1) ?>
                    },
                }],
                xAxes: [{
                    scaleLabel: {
                        fontSize: 18,
                        display: true,
                        labelString: 'วันที่'
                    },

                    ticks: {
                        fontColor: "blue",

                    }
                }]
            }
        }
    });
    </script>
</body>

</html>