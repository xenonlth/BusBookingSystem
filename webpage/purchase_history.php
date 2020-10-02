<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Speedy Bus | Purchase History</title>
        <?php include("../webpage/headinclude.html");?>
    </head>

    <body id="main">
        <?php 
            include("../scripts/commonFunction.php");
            include("../webpage/webpageSetting.php");
            include("../webpage/header.php"); 
        ?>

        <div id="content">
            <h2>Purchase History - <?php echo "$uname"?></h2>
            <?php

                //login data base
                $login = mysqli_connect('localhost','root','');
                if(!$login){
                    die('Could not connect: '.mysqli.error($login));
                }

                //select database
                $selectDatabase=mysqli_select_db($login,'bus_system');

                //if no database found
                if(!$selectDatabase){
                    echo"<p> No purchase history found</p>";
                }

                $username=$uname;
                $querySQL="SELECT * FROM payment_record p, user u, WHERE u.userId = p.userId && u.username ='$uname'";
                $purchaseDisplay=mysqli_query($login,$querySQL);


                //condition to loop if still have data
                while(!empty($purchaseDisplay) && $row=mysqli_fetch_array($purchaseDisplay)){
                    echo"<table>";
                
                    $query = "SELECT * FROM station_list s,bus_schedule b WHERE 
                                stationId = s.stationId = b.stationId && b.busId = ".$row['busId'];
                    
                    $busData = mysqli_fetch_array(mysqli_query($db,$query));

                    $query = "SELECT * FROM tickets WHERE ticketId = ".$row['ticketId'];

                    $ticketData = mysqli_fetch_array(mysqli_query($db,$query));

                    //table header
                    echo"<tr>
                    <th>Payment Id</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Payment Method</th>
                    <th>Card No</th>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Total Pax</th>
                    <th>Ticket Price</th>
                    <th>Total Paid</th>
                    </tr>"; 

                    echo"<tr>";
                    echo"<td>".$row['paymentId']."</td>";
                    echo"<td>".$row['firstName']."</td>";
                    echo"<td>".$row['lastName']."</td>";
                    echo"<td>".$row['paymentMethod']."</td>";
                    echo"<td>".$row['cardNo']."</td>";
                    echo"<td>".$busData['s.stationName']."-".$busData['s.stationArea']."-".$busData['s.stationState']."</td>";
                    echo"<td>".$row['travelDate']."</td>";
                    echo"<td>".$row['numPax']."</td>";
                    echo"<td>".$ticketData['price']."</td>";
                    echo"<td>".$row['totalPrice']."</td>";

                    echo"</table><br><br>";
                }
                

                mysqli_close($login);
                
        ?>
        </div>

        <?php
            include("../webpage/footer.html");
        ?>
    </body>
</html>
