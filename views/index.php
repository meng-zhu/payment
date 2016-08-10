<html>
    <head>
        <script type="text/javascript" src="/payment/jquery.js"></script>
        <script type="text/javascript">
            function check()
            {
                $("#show_info").html("");
                var account = $("#account").val();
                if(account != ""){
                    $("#show_info").html("<center><h3>帳號檢查中，請稍後...</h3></center>");
                    $.ajax({
                        url: "PaymentFlow/showPayMent/",
                        data: "&account="+account,
                        type:"POST",
                        dataType:'html',
                        success: function(data){
                            $("#show_info").html(data);
                        }
                    });
                }else{
                    $("#show_info").html("<center><h3>請輸入銀行帳號</h3><center>");
                }
            }
        </script>

        <meta charset="utf-8">
        <title>payment</title>
    </head>
    <body>
        <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' ="500" align="center" id="show_act";>
            <form role="form"  action="#" method="post" enctype="multipart/form-data">
            <tr>
                <td>
                    銀行帳號
                </td>
                <td>
                    <input class="form-control" placeholder="請輸入銀行帳號" id="account" name="account">
                </td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <button type="button" class="btn btn-default" id="checkbtn" onclick="check()">查詢餘額及明細</button>
                </center></td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <a href="Home/payMoney">
                        <button type="button" class="btn btn-default" id="payMoney" >出款</button>
                    </a>
                </center> </td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <a href="Home/earnMoney">
                        <button type="button" class="btn btn-default" id="earnMoney" >入款</button>
                    </a>
                </center></td>
            </tr>
            </form>
        </table>
        <div id="show_info"></div>
    </body>
</html>
