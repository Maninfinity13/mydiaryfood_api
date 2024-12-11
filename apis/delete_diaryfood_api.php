<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
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

//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $diaryfood->deleteDiaryfood();

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