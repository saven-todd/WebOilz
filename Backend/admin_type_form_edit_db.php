<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('../db.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
  $type_id = $_REQUEST["type_id"];
  $type_name = $_REQUEST["type_name"];
//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
  
  $sql = "UPDATE tbl_type SET  
      type_name='$type_name' 
      WHERE type_id='$type_id' ";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error($con));
mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  
  if($result){
  echo "<script type='text/javascript'>";
  echo "alert('แก้ไขอัพเดทสำเร็จ');";
  echo "$.ajax({
          url: 'type_list.php',
          cache: true,
          data: {
              id: id
          },
          success: function(response) {
            $('#data').html(response);
          }
        });";
  echo "</script>";
  }
  else{
  echo "<script type='text/javascript'>";
  echo "alert('ผิดพลาด');";
  echo "</script>";
}
?>