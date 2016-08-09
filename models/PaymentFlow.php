<?php
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Taipei');
class PaymentFlow
{
    public $db;
    
    public function __construct()
    {
        $dbconnect = "mysql:host=localhost;dbname=payment;port=443";
        $dbuser = "root";
        $dbpw = "";
        // 連接資料庫伺服器
        $this->db = new PDO($dbconnect, $dbuser, $dbpw);
        $this->db->exec("set names utf8");
    
    }
    
    public function __destruct()
    {
        $this->db = NULL;
    }
    
    public function checkBalance($account)
    {   
        $result = $this->db->prepare("SELECT * FROM `account` WHERE `account` = ? FOR UPDATE");
        $result->execute(array($account));//依序取代sql中"?"的值，並執行
    }
    
    public function paymentFlowInsertEarn($account,$money)
    {
        $datetime = date ("Y- m - d / H : i : s"); 
        $result = $this->db->prepare("INSERT INTO `payment_flow`(`money`,`account`,`date`) VALUES (?,?,?)");
        $result->execute(array($money,$account,$datetime));//依序取代sql中"?"的值，並執行
        return true;    
    }
    
    public function paymentFlowEearnMoney($account,$money)
    {   
        $this->paymentFlowInsertEarn($account,$money);
        $result = $this->db->prepare("UPDATE `account` SET `balance`= `balance`+? WHERE `account` = ?");
        $result->execute(array($money,$account));//依序取代sql中"?"的值，並執行
        return true;    
    }
    
    public function paymentFlowInsertPay($account,$money)
    {   $datetime = date ("Y- m - d / H : i : s"); 
        $money = "-".$money;
        $result = $this->db->prepare("INSERT INTO `payment_flow`(`money`,`account`,`date`) VALUES (?,?,?)");
        $result->execute(array($money,$account,$datetime));//依序取代sql中"?"的值，並執行
        return true;    
    }
    
    public function paymentFlowPayMoney($account,$money)
    {   
        $this->paymentFlowInsertPay($account,$money);
        $result = $this->db->prepare("UPDATE `account` SET `balance`= `balance`-? WHERE `account` = ?");
        $result->execute(array($money,$account));//依序取代sql中"?"的值，並執行
        return true;    
    }
    
    public function accountBalance($account)
    {
        $result = $this->db->prepare("SELECT * FROM `account` WHERE `account` = ?");
        $result->execute(array($account));//依序取代sql中"?"的值，並執行
        return $result; 
    }
    
    public function accountShowPayMent($account)
    {   
        $result = $this->db->prepare("SELECT * FROM `payment_flow` WHERE `account` = ?");
        $result->execute(array($account));//依序取代sql中"?"的值，並執行
        return $result; 
    }
}
