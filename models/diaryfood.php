<?php
class DiaryFood
{
    //ตัวแปรหลักที่จะใช้ติดต่อกับ DB
    public $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $foodId;
    public $foodShopname;
    public $foodMeal;
    public $foodImage;
    public $foodPay;
    public $foodDate;
    public $foodProvince;
    public $foodLat;
    public $foodLng;
    public $memId;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //คอนสตรักเตอร์
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //--------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ api

    //ฟังก์ชันดึงข้อมูลทั้งหมดจากตาราง saudiaryfood_tb
    public function getDiaryFoodAll()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM saudiaryfood_tb";

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันดึงข้อมูลเฉพาะข้อมูลการกินจากตาราง saudiaryfood_tb ของสมาชิกแต่ละคน
    public function getAllDiaryFoodByMemId()
    {
        $strSQL = "SELECT * FROM saudiaryfood_tb WHERE memId = :memId";

        $this->memId = intval(htmlspecialchars(strip_tags($this->memId)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":memId", $this->memId);
        $stmt->execute();
        return $stmt;
    }

    public function getAllFoodByMemMeal()
    {
        $strSQL = "SELECT * FROM saudiaryfood_tb WHERE memId = :memId AND foodMeal = :foodMeal";

        $this->memId = intval(htmlspecialchars(strip_tags($this->memId)));
        $this->foodMeal = intval(htmlspecialchars(strip_tags($this->foodMeal)));
        $stmt = $this->connDB->prepare($strSQL);
        $stmt->bindParam(":memId", $this->memId);
        $stmt->bindParam(":foodMeal", $this->foodMeal);
        $stmt->execute();
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลให้ ตาราง saudiaryfood_tb
    public function insertDiary(){
        $strSQL = "";
        if($this->foodImage == ""){
            $strSQL = "UPDATE
                saudiaryfood_tb
                SET
                foodShopname = :foodShopname, foodMeal = :foodMeal, foodPay = :foodPay, foodDate = :foodDate, foodProvince = :foodProvince, foodLat = :foodLat, foodLng = :foodLng,
                memId = :memId
                WHERE
                foodId = :foodId";
        
        }else{
            $strSQL = "UPDATE
            saudiaryfood_tb
                SET
                foodShopname = :foodShopname, foodMeal = :foodMeal, foodPay = :foodPay, foodDate = :foodDate, foodProvince = :foodProvince, foodLat = :foodLat, foodLng = :foodLng,
                memId = :memId
                WHERE
                foodId = :foodId";
        }
        $strSQL = "INSERT INTO 
                saudiaryfood_tb (
                    `foodShopname`, 
                    `foodMeal`, 
                    `foodImage`, 
                    `foodPay`, 
                    `foodDate`,
                    `foodProvince`,
                    `foodLat`,
                    `foodLng`,
                    `memId`
                )
                VALUES
                (
                    :foodShopname, 
                    :foodMeal, 
                    :foodImage, 
                    :foodPay, 
                    :foodDate,
                    :foodProvince,
                    :foodLat,
                    :foodLng,
                    :memId
                );";

        $this->foodShopname = htmlspecialchars(strip_tags($this->foodShopname));
        $this->foodMeal = intval(htmlspecialchars(strip_tags($this->foodMeal)));
        $this->foodImage = htmlspecialchars(strip_tags($this->foodImage));
        $this->foodPay = intval(htmlspecialchars(strip_tags($this->foodPay)));
        $this->foodDate = htmlspecialchars(strip_tags($this->foodDate));
        $this->foodProvince = htmlspecialchars(strip_tags($this->foodProvince));
        $this->foodLat = doubleval(htmlspecialchars(strip_tags($this->foodLat)));
        $this->foodLng = doubleval(htmlspecialchars(strip_tags($this->foodLng)));
        $this->memId = htmlspecialchars(strip_tags($this->memId));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":foodShopname", $this->foodShopname);
        $stmt->bindParam(":foodMeal", $this->foodMeal);
        if($this->foodImage != ""){
            $stmt->bindParam(":foodImage", $this->foodImage);
        }
        $stmt->bindParam(":foodPay", $this->foodPay);
        $stmt->bindParam(":foodDate", $this->foodDate);
        $stmt->bindParam(":foodProvince", $this->foodProvince);
        $stmt->bindParam(":foodLat", $this->foodLat);
        $stmt->bindParam(":foodLng", $this->foodLng);
        $stmt->bindParam(":memId", $this->memId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันแก้ไขข้อมูลในตาราง saudiaryfood_tb
    public function updateDiaryfood()
    {
        $strSQL = "UPDATE 
      saudiaryfood_tb 
    SET 
      foodShopname = :foodShopname,
      foodMeal = :foodMeal,
      foodImage = :foodImage,
      foodPay = :foodPay,
      foodDate = :foodDate,
      foodProvince = :foodProvince,
      foodLat = :foodLat,
      foodLng = :foodLng,
      memId = :memId
    WHERE 
      foodId = :foodId";

        $this->foodId = htmlspecialchars(strip_tags($this->foodId));
        $this->foodShopname = htmlspecialchars(strip_tags($this->foodShopname));
        $this->foodMeal = intval(htmlspecialchars(strip_tags($this->foodMeal)));
        $this->foodImage = htmlspecialchars(strip_tags($this->foodImage));
        $this->foodPay = intval(htmlspecialchars(strip_tags($this->foodPay)));
        $this->foodDate = htmlspecialchars(strip_tags($this->foodDate));
        $this->foodProvince = htmlspecialchars(strip_tags($this->foodProvince));
        $this->foodLat = doubleval(htmlspecialchars(strip_tags($this->foodLat)));
        $this->foodLng = doubleval(htmlspecialchars(strip_tags($this->foodLng)));
        $this->memId = htmlspecialchars(strip_tags($this->memId));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":foodId", $this->foodId);
        $stmt->bindParam(":foodShopname", $this->foodShopname);
        $stmt->bindParam(":foodMeal", $this->foodMeal);
        $stmt->bindParam(":foodImage", $this->foodImage);
        $stmt->bindParam(":foodPay", $this->foodPay);
        $stmt->bindParam(":foodDate", $this->foodDate);
        $stmt->bindParam(":foodProvince", $this->foodProvince);
        $stmt->bindParam(":foodLat", $this->foodLat);
        $stmt->bindParam(":foodLng", $this->foodLng);
        $stmt->bindParam(":memId", $this->memId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //ฟังก์ชันลบข้อมูลในตาราง saudiaryfood_tb
    public function deleteDiaryfood() {
        $strSQL = "DELETE FROM saudiaryfood_tb WHERE foodId = :foodId";

        $this->foodId = htmlspecialchars(strip_tags($this->foodId));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":foodId", $this->foodId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
