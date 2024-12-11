<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "./../connectdb.php";
require_once "./../models/diaryfood.php";

$connDB = new ConnectDB();
$diaryfood = new DiaryFood($connDB->getConnectionDB());

$data = json_decode(file_get_contents("php://input"));

$diaryfood->memId = $data->memId;

$result = $diaryfood->getAllDiaryFoodByMemId();

if($result->rowCount() > 0){
    //มี
    while ($resultData = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($resultData);

        //สร้างตัวแปรเป็น array เก็บข้อมูล
        $resultArray = array(
            "message" => "1",
            "foodId" => strval($foodId),
            "foodShopname" => $foodShopname,
            "foodMeal" => strval($foodMeal),
            "foodImage" => $foodImage,
            "foodPay" => strval($foodPay),
            "foodDate" => $foodDate,
            "foodProvince" => $foodProvince,
            "foodLat" => strval($foodLat),
            "foodLng" => strval($foodLng),
            "memId" => strval($memId)
        );
    }

    //echo json_encode(array("message" => "ชื่อผู้ใช้ หรือ รหัสผ่าน ถูกต้อง"));

    echo json_encode($resultArray, JSON_UNESCAPED_UNICODE);

}else{
    //ไม่มี
    $resultInfo = array();
    $resultArray = array(
        "message" => "0"
    );
    array_push($resultInfo, $resultArray);
    echo json_encode($resultInfo);

}