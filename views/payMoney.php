<html>
    <head>
        <meta charset="utf-8">
        <title>payment</title>
    </head>
    <body>
        <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
        <form role="form"  action="#" method="post" enctype="multipart/form-data">
            <tr>
                <td COLSPAN=2><center>
                    <label>出款</label>
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
                    <label>對方帳號:</label>
                </td>
                <td>
                    <input class="form-control" placeholder="對方的銀行帳號" id="account_or" name="account_or">
                </td>
            </tr>
            <tr>
                <td>
                    <label>金額:</label>
                </td>
                <td>
                    <input class="form-control" placeholder="請填寫出款金額" id="money" name="money" pattern="[0-9]{0,5}">
                </td>
            </tr>
            <tr>
                <td>
                    <label>備註</label>
                </td>
                <td>
                     <textarea rows="5" placeholder="備註說明" id="ps" name="ps"></textarea>
                </td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <button type="submit" class="btn btn-default" id="checkbtn">確認送出</button>
                </center></td>
            </tr>
            <tr>
                <td COLSPAN=2><center>
                    <button type="reset" class="btn btn-default" id="resetbtn" onclick="history.back()">回上一頁</button>
                </center></td>
            </tr>
        </form>
        </table>
    </body>
</html>