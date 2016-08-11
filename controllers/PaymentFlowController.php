<?php

class PaymentFlowController extends Controller
{
    /**
     * 確認是否有此帳戶
     */
    public function checkAccount($account)
    {
        $check = $this->model('Account');
        $checkAccount = $check->checkAccount($account);

        return $checkAccount;
    }

    /**
     * 出入款操作
     */
    public function withdrawalAndDeposit()
    {
        $type = $_POST['type'];
        $account = $_POST['account'];
        $money = $_POST['money'];
        $memo = $_POST['memo'];

        if ($money < 0) {
            $showInfo = '金額不得為負數';

            $this->view('showinformation', $showInfo);

            return;
        }

        // 先確認是否有此帳號
        $checkAccount = $this->checkAccount($account);

        if (!$checkAccount) {
            $showInfo = '帳號輸入錯誤';

            $this->view('showinformation', $showInfo);

            return;
        }

        try {
            $paymentFlow = $this->model('PaymentFlow');
            $paymentFlow->db->beginTransaction();

            // 執行 row lock
            $paymentFlow->lockBalance($account);

            // type: 出款/入款
            if ($type == '出款') {
                $result = $paymentFlow->withdrawal($account, $money, $memo, $type);

                $showInfo = '交易完成，已成功付出款項';

                if (!$result){
                    $showInfo = '交易失敗，帳戶餘額不足';

                    throw new PDOException($showInfo);
                }
            }

            if ($type == '入款') {
                $result = $paymentFlow->deposit($account, $money, $memo, $type);

                if ($result) {
                    $showInfo = '交易完成，已成功存入戶頭';
                }
            }

            $paymentFlow->db->commit();

            $this->view('showinformation', $showInfo);
        } catch(PDOException $showInfo) {
            $paymentFlow->db->rollback();

            $this->view('showinformation', $showInfo->getMessage());
        }

    }

    /**
     * 查看帳戶餘額及明細
     */
    public function showPayment()
    {
        $account = $_POST['account'];

        // 先確認是否有此帳號
        $checkAccount = $this->checkAccount($account);

        if (!$checkAccount) {
            $showInfo = '帳號輸入錯誤';

            $this->view('showinformation', $showInfo);

            return;
        }

        $paymentFlow = $this->model('PaymentFlow');
        $resultBalance = $paymentFlow->getBalance($account);
        $resultList = $paymentFlow->getList($account);

        $this->view('balance', $resultBalance, $resultList);
    }
}
