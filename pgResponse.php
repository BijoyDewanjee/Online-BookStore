<!DOCTYPE html>
<html>
<head>
  <title>Response</title>
    <link rel="stylesheet" type="text/css" href="css/pay_table.scss">
</head>
<body style="margin-top: 0%">

<?php
include("db.php");
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");





        if (isset($_POST) && count($_POST)>0 ){

            $sql = "SELECT * from temp_payments WHERE txn_id='{$_POST["ORDER_ID"]}';";
            $res = $db->query($sql);

            $res1=0;
            while($row = $res->fetch_assoc())
            {
                $sql1 = "INSERT INTO payments (txn_id, cus_id, bid) VALUES ('{$row['txn_id']}', {$row['cus_id']}, {$row['bid']})";
                $res1 = $db->query($sql1);

                $sql3 = "DELETE FROM cart WHERE bid={$row['bid']} and cus_id={$row['cus_id']};";
                $res3 = $db->query($sql3);    
            }

            $sql2 = "DELETE FROM temp_payments WHERE txn_id='{$_POST["ORDER_ID"]}';";
            $res2 = $db->query($sql2);

            if($res1){
                echo "<div class='aa_htmlTable'><h2 class='aa_h2' style='text-align:center; color:lime;'>Transaction Successful</h2>";
            }else{
                echo "<div class='aa_htmlTable'><h2 class='aa_h2' style='text-align:center; color:red;'>Transaction status failure</h2>";
            }
        }
        
    
    else {
        echo "<div class='aa_htmlTable'><h2 class='aa_h2' style='text-align:center; color:red;'>Transaction status failure</h2>";
    }

    if (isset($_POST) && count($_POST)>0 )
    {
        echo "<table><tbody>";
        foreach($_POST as $paramName => $paramValue) 
        {
            if(($paramName == 'MID') || ($paramName == 'TXNID') || ($paramName == 'RESPCODE') || ($paramName == 'CHECKSUMHASH'))
                continue;
            else
                echo "<tr><th>" . $paramName . "</th><td>" . $paramValue . "</td></tr>";
        }
        
        echo "
        
        <tr style='border-style: hidden'>
        <div style='display: inline;' align='center'><br><br>
        <td><div><button onclick='window.print()' style='color: white; background-color: #00ff00; padding: 15px 32px; text-align: center; text-decoration: none; border-radius: 4px;font-size: 100%;''>Print</button></div></td>
        <td><div><a href='book_purchased.php'><button style='color: white; background-color: #0099ff; padding: 15px 32px; text-align: center; text-decoration: none; border-radius: 4px; font-size: 100%;'>Back to store</button></a></div></td>
        </div>
        </tr>
        </tbody></table></div>
        </body>
        </html>
        ";
    }
    


else {
    echo "<b>Checksum mismatched.</b></body></html>";
    //Process transaction as suspicious.
}

?>
