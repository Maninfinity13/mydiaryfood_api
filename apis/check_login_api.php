
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/member.php";

//สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$member = new Member($connDB->getConnectionDB());

//รับค่าที่ส่งมาจาก Client/User ซึ่งเป็น JSON มาทำการ Decode เก็บในตัวแปร
$data = json_decode(file_get_contents("php://input"));

//เอาค่าในตัวแปรกำหนดให้กับ ตัวแปรของ Model ที่สร้างไว้
$member->memUsername = $data->memUsername;
$member->memPassword = $data->memPassword;

//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $member->checkLogin();

//ตรวจสอบข้อมูลจากการเรียกฟังก์ชันตรวจสอบชื่อผู้ใช้ รัหัสผ่าน
if($result->rowCount() > 0){
    $resultData = $result->fetch(PDO::FETCH_ASSOC);
    extract($resultData);

    //สร้างตัวแปรเป็น array เก็บข้อมูล
    $resultArray = array(
        "message" => "1",
        "memId" => $memId,
        "memFullname" => $memFullname,
        "memEmail" => $memEmail,
        "memUsername" => $memUsername,
        "memPassword" => $memPassword,
        "memAge" => $memAge
    );
    //echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่าน ถูกต้อง"));

    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}else{
    $resultArray = array(
        "message" => "0"
    );
    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
}
?>