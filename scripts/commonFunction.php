<?php
    function returnToHomepage(){
        echo "<br><br>";
        echo "<center>";
        echo "Please press the button below to return to homepage.";
        echo "<form action=\"../webpage/homepage.php\">";
        echo "<input type=\"submit\" value=\"go\">";
        echo "</form>";
        echo "</center>";
    }

    function returnToLogin(){
        echo "<br><br>";
        echo "<center>";
        echo "Please press the button below to login.";
        echo "<form action=\"../webpage/login.php\">";
        echo "<input type=\"submit\" value=\"go\">";
        echo "</form>";
        echo "</center>";
    }

    function validateEmail($email){
        $isValid = true;

        if(empty($email)){ 
            echo "<p>Email cannot be empty.</p>";
            $isValid=false;
        }//check format of email input
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo "The email is in wrong format!<br>";
            $isValid = false;
        }

        return $isValid;
    }

    function validateAlphabet($var,$name){
        $isValid = true;

        if(empty($var)){ 
            echo "<p>$name cannot be empty.</p>";
            $isValid=false;
        }
        else{
            if(!(ctype_alpha(str_replace(' ','',$var)))){ 
                echo "<p>$name only accept alphabet</p>";
                $isValid=false;
            }
        }

        return $isValid;
    }

    function checkEmpty($var,$name){
        $isValid = true;

        if(empty($var)){ 
            echo "<p>$name cannot be empty.</p>";
            $isValid=false;
        }

        return $isValid;
    }

    function validatePhone($phone_number){
        $isValid = true;

        if(empty($phone_number)){ 
            echo "<p>Phone number cannot be empty.</p>";
            $isValid=false;
        }
        else{	
            if(ctype_digit($phone_number)){
                echo "<p>phone number only accept</p>";
                $isValid=false;
            }

            if(strlen($phone_number)<10 || strlen($phone_number)>11){
                echo "<h3>Phone number out of length limit.</h3>";
                $isValid=false;
            }
        }
        
        return $isValid;
    }

    function validateUsername($username){
        $valid = true;

        if(empty($username)){
            echo "The username should not be empty!<br>";
            $valid = false;
        }
        else{
            //username length limit 50 character
            if(strlen($username)>50){
                echo "The username should not be more than 50 character!<br>";
                $valid = false;
            }
    
            $match = preg_match('/[^a-zA-Z0-9_]/',$username);
            if($match){
                echo "Username should only contain: lowercase character, uppercase character, digit and underscore(_)<br>";
                $valid = false;
            }

            if($db = mysqli_connect("localhost","root","")){
                if(mysqli_select_db($db,"bus_system")){

                    $query = "SELECT username FROM user WHERE username=$username";
                    
                    if(!mysqli_num_rows(mysqli_query($db,$query))==0){
                        echo "<p>The username had been registered, Please try again!</p>";
                        $valid = false;
                    }
                }
                else{
                    echo "<p>Failed to connect to database!</p>";
                    $valid = false;
                }

                mysqli_close($db);
            }else{
                echo "Failed to connect to database server!</p>";
                $valid = false;
            }
        }

        return $valid;
    }

    function validatePassword($password){
        $valid = true;

        if(empty($password)){
            echo "The password should not be empty!<br>";
            $valid = false;
        }
        else{
            //must more than 8 character
            if(strlen($password)<8){
                echo "The password length should be at least 8 character!<br>";
                $valid = false;
            }
            
            //must contain lowercase, uppercase and symbol
            $match1=preg_match('/[a-z]/',$password);
            $match2=preg_match('/[A-Z]/',$password);
            $match3=preg_match('/[0-9]/',$password);
    
            if(!$match1 || !$match2 || !$match3){
                echo "The password should be the combination of :lowercase character, uppercase character, digit.<br>";
                $valid = false;
            }
    
            $match = preg_match('/[^a-zA-Z0-9_]/',$password);
            if($match){
                echo "The password should only contain: lowercase character, uppercase character, digit and underscore(_)<br>";
                $valid = false;
            }
        }

        return $valid;
    }
?>
