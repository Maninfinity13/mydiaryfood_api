<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/diaryfood.php";

//สร้าง instance (object/ตัวแทน)
$connDB = new ConnectDB();
$diaryfood = new DiaryFood($connDB->getConnectionDB());

//เรียกใช้ฟังก์ชันตรวจสอบชื่อผู้ใช้ รหัสผ่าน
$result = $diaryfood->getDiaryFoodAll();

//ตรวจสอบข้อมูลจากการเรียกฟังก์ชันตรวจสอบชื่อผู้ใช้ รัหัสผ่าน
if ($result->rowCount() > 0) {
    $resultData = array();

    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);

        //สร้างตัวแปรเป็น array เก็บข้อมูล
        $resultArray = array(
            "message" => "1",
            "foodId" => $foodId,
            "foodShopname" => $foodShopname,
            "foodImage" => $foodImage,
        );

        array_push($resultInfo, $resultArray);
    }

    //echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่าน ถูกต้อง"));

    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);
} else {
    $resultInfo = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultInfo, $resultArray);
    echo json_encode($resultInfo);
}
?>