<html>
    <head>
        <script type="text/javascript" src="/payment/jquery.js"></script>
        <script type="text/javascript">
            function check()
            {
                var account = $("#account").val();
                var money = $("#money").val();
                var memo= $("#memo").val();
                var type = "入款";

                if(account != "" && money != ""){
                    $("#show_info").html("<center><h3>交易進行中，請稍後...</h3></center>");
                    $.ajax({
                        url: "../PaymentFlow/money/",
                        data: "&type="+type+"&account="+account+"&money="+money+"&memo="+memo,
                        type:"POST",
                        dataType:'html',
                        success: function(data){
                            $("#show_info").html(data);
                        }
                    });
                }else{
                    $("#show_info").html("<center><h3>資料輸入不完全</h3><center>");
                }

            }
        </script>
        <meta charset="utf-8">
        <title>payment</title>
    </head>
    <body>
        <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
        <form>
            <tr>
                <td COLSPAN=2><center>
                    <label>入款</label>
                </center></td>
            </tr>
            <tr>
                <td>
                    <label>帳號:</label>
                </td>
                <td>
                    <input class="form-control" placeholder="銀行帳號" id="account" name="account">
                </td>
            </tr>
            <tr>
                <td>
                    <label>金額:</label>
                </td>
                <td>
                    <input class="form-control" placeholder="請填寫入款金額" id="money" name="money" pattern="[0-9]{0,5}">
                </td>
            </tr>
            <tr>
                <td>
                    <label>備註說明：</label>
                </td>
                <td>
                    <textarea placeholder="請輸入備註說明" id="memo" name="memo"></textarea>
                </td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <button type="button" class="btn btn-default" id="checkbtn" onclick="check()">確認送出</button>
                </center></td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <button type="reset" class="btn btn-default" id="resetbtn" onclick="history.back()">回上一頁</button>
                </center></td>
            </tr>
        </form>
        </table>
        <div id="show_info"></div>
    </body>
</html>