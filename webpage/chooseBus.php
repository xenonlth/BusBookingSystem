<!DOCTYPE html>
<html lang="en">
<head>
    <title>Choose Bus | Speedy Bus</title>
    <script src="../scripts/num-btn.js"></script>
    <?php include("headinclude.html"); ?>
</head>

<body id="main">
    <?php
        include("webpageSetting.php");
        include("../scripts/commonFunction.php");
        include("header.php");

        echo "<div id=\"content\"><center>";
        
    
        /*
        -----validation-----
        */

        //login data base
        if($db = mysqli_connect('localhost','root','')){
            //if no database found
            if(mysqli_select_db($db,'bus_system')){

                if(isset($_POST['submitted'])){
                    if(emptu($uname)){
                        echo "<p>Please login before buy the ticket</p>";
                        returnToLogin();
                        $submitted = false;
                    }else{
                        $type = $_POST['form_type'];
                        $state = $_POST['state'];
                        $station = $_POST['station'];
                        $month = $_POST['month'];
                        $day = $_POST['day'];
                        $area = "";
                        $query = "SELECT stationArea FROM station_list WHERE stationName = '$station'";

                        $data = mysqli_query($db,$query);
                        if(!empty($data) && $row = mysqli_fetch_array($data)){
                            $area = $row['stationArea'];
                        }

                        $submitted = true;
                    }
                }
                
                else if(isset($_GET['formSelected'])){
                    if(emptu($uname)){
                        echo "<p>Please login before buy the ticket</p>";
                        returnToLogin();
                        $submitted = false;
                    }else{
                        $type = $_GET['formSelected'];
                        $state = $_GET['states'];
                        $area = $_GET['area'];
                        $station = $_GET['station'];
                        $month = $_GET['month'];
                        $day = $_GET['day'];
                        $submitted = true;
                    }
                }
                else{
                    $submitted = false;
                }

                if($submitted)
                echo "<form action=\"paymentForm.php\" method=\"post\">";
                

                if($type == "1"){
                    $type = "oneway_ticket";

                    echo "<label for=\"type\">Ticket Type</label><br>";
                    echo "<input type=\"text\" name=\"type\" value=\"$type\" readonly><br><br>";

                    echo "<label for=\"state\">State</label><br>";
                    echo "<input type=\"text\" name=\"state\" value=\"$state\" readonly><br><br>";

                    echo "<label for=\"area\">Area</label><br>";
                    echo "<input type=\"text\" name=\"area\" value=\"$area\" readonly><br><br>";

                    echo "<label for=\"area\">Station</label><br>";
                    echo "<input type=\"text\" name=\"station\" value=\"$station\" readonly><br><br>";

                    echo "<label for=\"month\">Month</label><br>";
                    echo "<input type=\"text\" name=\"month\" value=\"$month\" readonly><br><br>";

                    echo "<label for=\"busId\">day</label><br>";
                    echo "<input type=\"text\" name=\"day\" value=\"$day\" readonly><br><br>";

                    echo "<label for=\"busId\">Bus</label><br>";
                    echo "<select name=\"busId\">";

                    $query = "SELECT * 
                            FROM bus_schedule b, station_list s 
                            WHERE stationState == $state 
                                    && s.stationArea == $area
                                    && s.stationName == $station
                                    && s.stationId == b.stationId
                                    && s.dayTravel == DATENAME(weekday,CONVERT(DATE,CAST([Year(GETDATE())] AS VARCHAR(4))+'-'+
                                                                                CAST([$month] AS VARCHAR(2))+'-'+
                                                                                CAST([$day] AS VARCHAR(2))))";
                    
                    $data = mysqli_query($db,$query);
                    while(!empty($data) && $row = mysqli_fetch_array($data)){
                        echo "<option value=\"".$row['b.busId']."\">".$row['b.busNo']." - ".$row['b.timeArrived']."</option>";
                    }

                    echo "</select>";
                    echo "<br><br>";

                }
                else if($type == "2"){
                    $type = "roundtrip_ticket";

                    echo "<label for=\"type\">Ticket Type</label><br>";
                    echo "<input type=\"text\" name=\"type\" value=\"$type\" readonly><br><br>";

                    echo "<label for=\"state\">State</label><br>";
                    echo "<input type=\"text\" name=\"state\" value=\"$state\" readonly><br><br>";

                    echo "<label for=\"area\">Area</label><br>";
                    echo "<input type=\"text\" name=\"area\" value=\"$area\" readonly><br><br>";

                    echo "<label for=\"area\">Station</label><br>";
                    echo "<input type=\"text\" name=\"station\" value=\"$station\" readonly><br><br>";

                    echo "<label for=\"month\">Month</label><br>";
                    echo "<input type=\"text\" name=\"month\" value=\"$month\" readonly><br><br>";

                    echo "<label for=\"day\">day</label><br>";
                    echo "<input type=\"text\" name=\"day\" value=\"$day\" readonly><br><br>";

                    echo "<label for=\"busId\">Bus</label><br>";
                    echo "<select name=\"busId\">";

                    $query = "SELECT * 
                            FROM bus_schedule b, station_list s 
                            WHERE stationState == $state 
                                    && s.stationArea == $area
                                    && s.stationName == $station
                                    && s.stationId == b.stationId
                                    && s.dayTravel == DATENAME(weekday,CONVERT(DATE,CAST([Year(GETDATE())] AS VARCHAR(4))+'-'+
                                                                                CAST([$month] AS VARCHAR(2))+'-'+
                                                                                CAST([$day] AS VARCHAR(2))))";
                    
                    $data = mysqli_query($db,$query);
                    while(!empty($data) && $row = mysqli_fetch_array($data)){
                        echo "<option value=\"".$row['b.busId']."\">".$row['b.busNo']." - ".$row['b.timeArrived']."</option>";
                    }

                    echo "</select>";
                    echo "<br><br>";

                }
                else if($type == "3"){
                    $type = "daily_ticket";

                    echo "<label for=\"type\">Ticket Type</label><br>";
                    echo "<input type=\"text\" name=\"type\" value=\"$type\" readonly><br><br>";

                    echo "<label for=\"state\">State</label><br>";
                    echo "<input type=\"text\" name=\"state\" value=\"$state\" readonly><br><br>";

                    echo "<label for=\"month\">Month</label><br>";
                    echo "<input type=\"text\" name=\"month\" value=\"$month\" readonly><br><br>";

                    echo "<label for=\"busId\">day</label><br>";
                    echo "<input type=\"text\" name=\"day\" value=\"$day\" readonly><br><br>";
                    echo "<input type=\"hidden\" name=\"station\" value=\"$station\">";
                    echo "<input type=\"hidden\" name=\"area\" value=\"$area\">";
                }
                else if($type == "4"){
                    $type = "monthly_ticket";

                    echo "<label for=\"type\">Ticket Type</label><br>";
                    echo "<input type=\"text\" name=\"type\" value=\"$type\" readonly><br><br>";

                    echo "<label for=\"state\">State</label><br>";
                    echo "<input type=\"text\" name=\"state\" value=\"$state\" readonly><br><br>";

                    echo "<label for=\"month\">Month</label><br>";
                    echo "<input type=\"text\" name=\"month\" value=\"$month\" readonly><br><br>";

                    echo "<input type=\"hidden\" name=\"day\" value=\"$day\">";
                    echo "<input type=\"hidden\" name=\"station\" value=\"$station\">";
                    echo "<input type=\"hidden\" name=\"area\" value=\"$area\">";
                }
                else{
                    echo "Oops! An error had occured when the server try to get the data.<br>";
                    returnToHomepage();
                }

                echo "<lable for=\"numPax\">No. of pax</lable>
                    <input type=\"button\" class=\"change-btn\" onclick=\"minus1();\" value=\"&lt;\">
                    <input type=\"number\" id=\"num-btn\" name=\"numPax\" keyup=\"check_value\">
                    <input type=\"button\" class=\"change-btn\" onclick=\"add1();\" value=\"&gt;\">
                    <br><br>
                    Maximum purchase:<input type=\"number\" id=\"stk\" value=\"10\" readonly><br><br>";

                echo "<input type=\"submit\" value=\"Buy now\">";
                echo "<input type=\"hidden\" name=\"type\" value=\"$type\">";
                echo "</form>";
            
            }else{
                die('Could not connect: '.mysqli.error($db));
                returnToHomepage();
            }

            mysqli_close($db);
        }else{
            die('Could not connect: '.mysqli.error($db));
            returnToHomepage();
        }
    
        echo "</center></div>";
        include("footer.html");
    ?>
</body>
</html>
