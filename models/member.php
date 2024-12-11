

<?php
class Member
{
    //ตัวแปรหลักที่จะใช้ติดต่อกับ DB
    public $connDB;

    //ตัวแปรที่ทำงานคู่กับคอลัมน์(ฟิวล์)ในตาราง
    public $memId;
    public $memFullname;
    public $memEmail;
    public $memUsername;
    public $memPassword;
    public $memAge;

    //ตัวแปรสารพัดประโยชน์
    public $message;

    //คอนสตรักเตอร์
    public function __construct($connDB)
    {
        $this->connDB = $connDB;
    }

    //--------------------------------------
    //ฟังก์ชันการทำงานที่ล้อกับส่วนของ api
    public function checkLogin()
    {
        //ตัวแปรเก็บคำสั่ง SQL
        $strSQL = "SELECT * FROM member_tb WHERE memUsername = :memUsername AND memPassword = :memPassword";

        //ตรวจสอบค่าที่ส่งมาจาก Client/User ก่อนที่จะกำหนดให้กับ parameter (:???????)
        $this->memUsername = htmlspecialchars(strip_tags($this->memUsername));
        $this->memPassword = htmlspecialchars(strip_tags($this->memPassword));

        //สร้างตัวแปรที่ใช้ทำงานกับคำสั่ง SQL
        $stmt = $this->connDB->prepare($strSQL);

        //เอาที่ผ่านตรวจสอบแล้วไปกำหนดให้กับ parameter
        $stmt->bindParam(":memUsername", $this->memUsername);
        $stmt->bindParam(":memPassword", $this->memPassword);

        //สั่งให้ SQL ทำงาน
        $stmt->execute();

        //ส่งค่าผลการทำงานกลับไปยังจุดเรียกใช้ฟังก์ชันนี้
        return $stmt;
    }

    //ฟังก์ชันเพิ่มข้อมูลผู้ใช้ใหม่
    public function registerMember()
    {
        $strSQL = "INSERT INTO 
                member_tb (
                    `memFullname`, 
                    `memEmail`, 
                    `memUsername`, 
                    `memPassword`, 
                    `memAge`
                )
                VALUES
                (
                    :memFullname, 
                    :memEmail, 
                    :memUsername, 
                    :memPassword, 
                    :memAge
                );";

        $this->memAge = intval(htmlspecialchars(strip_tags($this->memAge)));
        $this->memFullname = htmlspecialchars(strip_tags($this->memFullname));
        $this->memEmail = htmlspecialchars(strip_tags($this->memEmail));
        $this->memUsername = htmlspecialchars(strip_tags($this->memUsername));
        $this->memPassword = htmlspecialchars(strip_tags($this->memPassword));

        $stmt = $this->connDB->prepare($strSQL);

        $stmt->bindParam(":memFullname",$this->memFullname);
        $stmt->bindParam(":memEmail",$this->memEmail);
        $stmt->bindParam(":memUsername",$this->memUsername);
        $stmt->bindParam(":memPassword",$this->memPassword);
        $stmt->bindParam(":memAge",$this->memAge);

        if( $stmt ->execute() ){
            return true;
        }else{
            return false;
        }
    }

}
