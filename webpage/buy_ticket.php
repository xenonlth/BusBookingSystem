<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Speedy Bus | Buy tickets</title>
        <?php include("../webpage/headinclude.html"); ?>
    </head>

    <body id="main">
        <?php 
            include('../webpage/webpageSetting.php');
            include('../scripts/commonFunction.php');
            include("../webpage/header.php");
            
            //connect database
            if($db = mysqli_connect("localhost","root","")){
                if(mysqli_select_db($db,"bus_system")){
                    
        ?>

        <div id="content">
            <?php
                $months = array("January"=>31,"February"=>28,"March"=>31,"April"=>30,"May"=>31,"June"=>30,
                "July"=>31,"August"=>31,"September"=>30,"October"=>31,"November"=>30,"December"=>31);

                echo "<h2>Month</h2>";
                if(!empty($_GET['month'])){
                    $month = $_GET['month'];
                }else{
                    $month = 0;
                }

                //print the form selection bar
                echo "<ul id=\"homepage-select\" type=\"none\">";
                    foreach($months as $key => $num){
                        if($key === $month){
                            echo "  <li class=\"homepage-form\">
                                        <a href=\"buy_ticket.php?month=".($key)."\" class=\"homepage-form-text blackBlock\">
                                            $key
                                        </a>
                                    </li>";
                        }else{
                        echo "  <li class=\"homepage-form\">
                                    <a href=\"buy_ticket.php?month=".($key)."\" class=\"homepage-form-text\">
                                        $key
                                    </a>
                                </li>";
                        }
                    }
                echo "</ul>";

                if(!empty($month)){

                    echo "<h2>Day</h2>";
                    if(!empty($_GET['day'])){
                        $day = $_GET['day'];
                    }else{
                        $day = 0;
                    }
                    
                    //print the form selection bar
                    echo "<ul id=\"homepage-select\" type=\"none\">";
                        for($i=1;$i<=31;++$i){
                            if($i == $day){
                                echo "  <li class=\"homepage-form\">
                                            <a href=\"buy_ticket.php?month=$month&&day=".($i)."\" class=\"homepage-form-text blackBlock\">
                                                $i
                                            </a>
                                        </li>";
                            }else{
                            echo "  <li class=\"homepage-form\">
                                        <a href=\"buy_ticket.php?month=$month&&day=".($i)."\" class=\"homepage-form-text\">
                                            $i
                                        </a>
                                    </li>";
                            }
                        }
                    echo "</ul>";
                }


                if(!empty($day)){
                    $formType = array("One Way","Round Trip","Day Pass","Monthly Pass");

                    echo "<h2>Ticket Type</h2>";
                    if(!empty($_GET['formSelected'])){
                        $formSelected = $_GET['formSelected'];
                    }else{
                        $formSelected = -1;
                    }

                    //print the form selection bar
                    echo "<ul id=\"homepage-select\" type=\"none\">";
                        foreach($formType as $key => $type){
                            if($key == (int)$formSelected-1){
                                echo "  <li class=\"homepage-form\">
                                            <a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=".($key+1)."\" class=\"homepage-form-text blackBlock\">
                                                $type
                                            </a>
                                        </li>";
                            }else{
                            echo "  <li class=\"homepage-form\">
                                        <a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=".($key+1)."\" class=\"homepage-form-text\">
                                            $type
                                        </a>
                                    </li>";
                            }
                        }
                    echo "</ul>";
                }

                if(!empty($formSelected) && $formSelected!= -1){
            ?>

                    <div id="buy-ticket-content">
                        <div id="buy-ticket-state">
                            <h1 class="selection-title">State:</h1>
                            <ul id="choose-state" type="none">
                            <?php
                                if(!empty($_GET['states']))
                                    $getState = $_GET['states'];
                                else
                                    $getState = "";
                                
                                $states = array("Perlis","Kelantan","Kedah","Penang","Pahang",
                                "Selangor","Kuala Lumpur","Puchong","Melaka","Terengganu","Johor","Sabah","Sarawak");

                                foreach($states as $row){
                                    echo "<li class=\"selection\">";
                                    if($getState == $row)
                                        echo "<a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=$formSelected".
                                            "&&states=$row\" class=\"selection-text blackBlock\">";
                                    else
                                        echo "<a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=$formSelected".
                                            "&&states=$row\" class=\"selection-text\">";
                                    
                                    echo "      $row
                                            </a>
                                        </li>";
                                }
                            ?>
                            </ul>
                        </div>
                        
                        <?php
                        $areas = array();

                        if(!empty($_GET['area']))
                            $getArea = $_GET['area'];
                        else
                            $getArea = "";

                        if(!empty($getState)){
                            $query = "SELECT DISTINCT stationArea FROM station_list WHERE stationState='$getState'";
                            $data = mysqli_query($db,$query);

                            while(!empty($data) && $row = mysqli_fetch_array($data)){
                                $areas[] = $row['stationArea'];
                            }
                        echo "
                        <div id=\"buy-ticket-area\">
                            <h1 class=\"selection-title\">Area:</h1>
                            <ul id=\"choose-area\" type=\"none\">";
                        
                        foreach($areas as $row){
                            if($row == $getArea)
                                echo "<li class=\"selection\"><a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=formSelected=$formSelected".
                                        "&&states=$getState&&area=$row\" class=\"selection-text blackBlock\">$row</a></li>";
                            else
                                echo "<li class=\"selection\"><a href=\"buy_ticket.php?month=$month&&day=$day&&formSelected=$formSelected".
                                    "&&states=$getState&&area=$row\" class=\"selection-text\">$row</a></li>";
                        }
                        echo  "</ul>
                        </div>";

                        } 
                        ?>

                        <?php
                        $stations = array();

                        if(!empty($getArea)){
                            $query = "SELECT stationName FROM station_list WHERE stationState='$getState' && stationArea='$getArea'";
                            $data = mysqli_query($db,$query);
                            while(!empty($data) && $row = mysqli_fetch_array($data)){
                                $stations[] = $row['stationName'];
                            }
                        echo "
                        <div id=\"buy-ticket-station\">
                            <h1 class=\"selection-title\">Station:</h1>
                            <ul id=\"choose-station\" type=\"none\">";

                        foreach($stations as $row){
                            echo "<li class=\"selection\"><a href=\"chooseBus.php?month=$month&&day=$day&&formSelected=$formSelected".
                            "&&states=$getState&&area=$getArea&&station=$row\" class=\"selection-text\">$row</a></li>";
                        }
                        echo    "</ul>
                        </div>";
                        }
                    } 
                }else{
                    die("Failed to select the database. Please try again later.");
                }
            }else{
                die("Failed to connect to the database server. Please try again later.");    
            }
            ?>
        </div>

        <?php
            include("../webpage/footer.html");
        ?>
    </body>
</html>
