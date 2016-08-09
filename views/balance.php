<html>
    <head>
        <meta charset="utf-8">
        <title>payment</title>
    </head>
    <body>
        <center><h1>銀行餘額</h1><center>
            <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
                <?php   foreach($data as $KEY)
                        {                    ?>
                <tr>
                    <td><cneter>
                        帳號
                    </cneter></td>
                    <td><center>
                        <?php echo $KEY['account'];?>
                    </center></td>
                </tr>
                <tr>
                    <td><center>
                        餘額
                    </center></td>
                    <td><center>
                        <?php echo $KEY['balance'];}?>
                    </center></td>
                </tr>
            </table>
        <hr style="border:1px #9C9FAD dashed;">
        <center><h1>帳目明細</h1><center>
            <table  style="border:3px #FFAC55 dashed;padding:5px;" rules="all" cellpadding='5' align="center";>
                <tr>
                    <td><center>
                        交易紀錄
                    </center></td>
                </tr>
                <?php   foreach($data2 as $KEY2)
                        { ?>
                <tr>
                    <td Style="text-align:right" >
                        <?php echo $KEY2['money']; ?>
                    </td>
                </tr>
                <?php   } ?> 
                
            </table>
          
    </body>
</html>

