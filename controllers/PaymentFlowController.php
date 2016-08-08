<?php
class PaymentFlowController extends Controller {
    function checkAccount($ACCOUNT)
    {
        $ACCOUNT = $_GET['account'];
        $CHECK = $this->model("Account");
        $CHECK_ACCOUNT = $CHECK->check_account($ACCOUNT);
        return $CHECK_ACCOUNT;
    }
    function earnMoney()
    {
        $ACCOUNT = $_GET['account'];
        $MONEY = $_GET['money'];
        /* 先確認是否有此帳號 */
        $CHECK_ACCOUNT = $this->checkAccount($ACCOUNT);
        if($CHECK_ACCOUNT){
            $PAYMENTFLOW = $this->model("PaymentFlow");
            $RESULT = $PAYMENTFLOW->paymentFlowEearnMoney($ACCOUNT,$MONEY);
            if($RESULT){
                $SHOW_INFO = "交易完成，已成功存入戶頭";    
            }else{
                $SHOW_INFO = "交易失敗，請在試一次";
            }
        }else{
            $SHOW_INFO = "帳號輸入錯誤";
        }
        $this->view("showinformation",$SHOW_INFO);
    }
}
?>