<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/diaryfood.php";

//สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$diaryfood = new DiaryFood($connDB->getConnectionDB());

//รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

$diaryfood->foodId = $data->foodId;
$diaryfood->foodShopname = $data->foodShopname;
$diaryfood->foodMeal = $data->foodMeal;
//$diaryfood->foodImage = $data->foodImage;
$diaryfood->foodPay = $data->foodPay;
$diaryfood->foodDate = $data->foodDate;
$diaryfood->foodProvince = $data->foodProvince;
$diaryfood->foodLat = $data->foodLat;
$diaryfood->foodLng = $data->foodLng;
$diaryfood->memId = $data->memId;

//กรณีแก้ไข ต้องตรวจสอบก่อนว่ามีการอัพรูปใหม่มีหรือไม่
if( isset($data->foodImage)){
// ----------------------จัดการเรื่องการ อัปโหลดรูป ในที่นี้เราใช้ Baser64------------------------------------------------
// เอารูปที่ส่งมาซึ่งเป็น base64 เก็บไว้ในตัวแปรตัวหนึ่ง
$picture_temp = $data->foodImage;
// ตั้งชื่อรูปใหม่เพื่อใช้กับรูปที่เป็น base64 ที่ส่งมา
$picture_filename = "pic_" . uniqid() . "_" . round(microtime(true)*1000) . ".jpg";
// เอารูปที่ส่งมาซึ่งเป็น base64 แปลงเป็นรู)ภาพ แล้วเอาไปไว้ที่ picupload/food/
// file_put_contents(ที่อยู่ของชื่อไฟล์      ,   ตัวไฟล์มี่อัพโหลดเก็บไว้เก็บไว้ในตัวแปร)
file_put_contents("./../picupload/food/" . $picture_filename, base64_decode($picture_temp));
// เอาชื่อไฟล์ไปกำหนดให้กับตัวแปรที่จะเก็บลงตารางในฐานข้อมูล
$diaryfood->foodImage = $picture_filename;
// ----------------------------------------------------------
}else{
    $diaryfood->foodImage = "";
}





//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $diaryfood->updateDiaryfood();

//ตรวจสอบข้อมูลจากการเรียกฟังก์ชันตรวจสอบชื่อผู้ใช้ รัหัสผ่าน
if($result == true){
    //insert - update - delete สำเร็จ
    $resultArray = array(
        "message" => "1"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}else{
    //insert - update - delete ไม่สำเร็จ
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>