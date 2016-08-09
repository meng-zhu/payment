<?php
class PaymentFlowController extends Controller {
    function checkAccount($ACCOUNT)
    {
        $CHECK = $this->model("Account");
        $CHECK_ACCOUNT = $CHECK->check_account($ACCOUNT);
        return $CHECK_ACCOUNT;
    }
    function Money()
    {   
        $TYPE = $_GET['type'];
        $ACCOUNT = $_GET['account'];
        $MONEY = $_GET['money'];
        /* 先確認是否有此帳號 */
        $CHECK_ACCOUNT = $this->checkAccount($ACCOUNT);
        if($CHECK_ACCOUNT){
            $PAYMENTFLOW = $this->model("PaymentFlow");
            if($TYPE == 1){
                $RESULT = $PAYMENTFLOW->paymentFlowPayMoney($ACCOUNT,$MONEY);
                if($RESULT){
                    $SHOW_INFO = "交易完成，已成功付出款項";    
                }else{
                    $SHOW_INFO = "交易失敗，請在試一次";
                }
            }else{
                $RESULT = $PAYMENTFLOW->paymentFlowEearnMoney($ACCOUNT,$MONEY);
                if($RESULT){
                    $SHOW_INFO = "交易完成，已成功存入戶頭";    
                }else{
                    $SHOW_INFO = "交易失敗，請在試一次";
                }
            }
        }else{
            $SHOW_INFO = "帳號輸入錯誤";
        }
        $this->view("showinformation",$SHOW_INFO);
    }
    function ShowPayMent()
    {   
        $ACCOUNT = $_GET['account'];
        /* 先確認是否有此帳號 */
        $CHECK_ACCOUNT = $this->checkAccount($ACCOUNT);
        if($CHECK_ACCOUNT){
            $PAYMENTFLOW = $this->model("PaymentFlow");
            $RESULT_BALANCE = $PAYMENTFLOW->AccountBalance($ACCOUNT);
            $RESULT_ALL = $PAYMENTFLOW->AccountShowPayMent($ACCOUNT);
            $this->view("balance",$RESULT_BALANCE,$RESULT_ALL);
            $SHOW_INOF = "帳號輸入正確";
        }else{
            $SHOW_INFO = "帳號輸入錯誤";
            $this->view("showinformation",$SHOW_INFO);
        }
        // echo "123";
        // $SHOW_INFO = "yio";
        // $this->view("showinformation",$SHOW_INFO);
    }
}
?>