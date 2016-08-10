<html>
    <head>
        <meta charset="utf-8">
        <title>payment</title>
    </head>
    <body>
        <center><h1>銀行餘額</h1><center>
            <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
                <?php   foreach($data as $key)
                        {                    ?>
                <tr>
                    <td><cneter>
                        帳號
                    </cneter></td>
                    <td><center>
                        <?php echo $key['account'];?>
                    </center></td>
                </tr>
                <tr>
                    <td><center>
                        餘額
                    </center></td>
                    <td><center>
                        <?php echo $key['balance'];}?>
                    </center></td>
                </tr>
            </table>
        <hr style="border:1px #9C9FAD dashed;">
        <center><h1>帳目明細</h1><center>
            <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
                <tr>
                    <td COLSPAN=5><center>
                        交易紀錄
                    </center></td>
                </tr>
                <tr>
                    <td><center>
                        交易日期
                    </center></td>
                    <td><center>
                        備註說明
                    </center></td>
                    <td><center>
                        操作項目
                    </center></td>
                    <td><center>
                        本次交易金額
                    </center></td>
                    <td><center>
                        結餘
                    </center></td>

                </tr>
                <?php   foreach($data2 as $key2)
                        { ?>
                <tr>
                    <td Style="text-align:right" >
                        <?php echo $key2['date']; ?>
                    </td>
                    <td Style="text-align:right" >
                        <?php echo $key2['memo']; ?>
                    </td>
                    <td Style="text-align:right" >
                        <?php echo $key2['type']; ?>
                    </td>
                    <td Style="text-align:right" >
                        <?php echo $key2['money']; ?>
                    </td>
                    <td Style="text-align:right" >
                        <?php echo $key2['balance']; ?>
                    </td>
                </tr>
                <?php   } ?>

            </table>

    </body>
</html>

