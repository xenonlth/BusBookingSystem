<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Speedy Bus | Sign Up</title>
		<meta charset="utf-8">
        <link rel="icon" href="../pictures/logo.png">
        <link rel="stylesheet" type="text/css" href="../scripts/style.css">
        <script src="../scripts/slider.js"></script>
	</head>	
	<body id="main">
        <?php
            include('../webpage/webpageSetting.php');
            include('../scripts/commonFunction.php');
        ?>

        <div id="header">
            <ul id="nav-bar" type="none">
                <li><a href="../webpage/homepage.php" class="header-typeA"><img src="../pictures/logo.png" width="70px" height="45px" id="header-img"></a></li>
                <li><a href="../webpage/homepage.php" class="header-typeA"><p>Speedy Bus</p></a></li>
                <li><a href="../webpage/buy_ticket.php" class="header-typeA"><p>Buy Tickets</p></a></li>
                <li><a href="../webpage/contact.php" class="header-typeA"><p>Contact Us</p></a></li>
                <?php
                    if(!empty($uname)){
                        echo "<li><a href=\"../webpage/login.php\" class=\"header-typeB\"><p>Hi $uname</p></a></li>";
                        echo "<li><a href=\"../webpage/purchase_history.php\" class=\"header-typeB\"><p>Shopping Cart</p></a></li>";
                    }else{
                        echo "<li><a href=\"../webpage/login.php\" class=\"header-typeB\"><p>Sign In</p></a></li>";
                    }

                    echo"
                    <li>
                        <a href=\"../webpage/userSetting.php\" class=\"header-typeB\">
                            <p>
                                Language:<i class=\"red-text\">$language</i> 
                                State:<i class=\"red-text\">$state</i> 
                                Background Colour:<i class=\"red-text\">$bgcolor</i>
                            </p>
                        </a>
                    </li>";
                ?>
            </ul>
        </div>

        <div id="content">
        <?php
            if(isset($_POST['submitted'])){

                //login data base
                if($login = mysqli_connect('localhost','root','')){
                    //select database
                    if(mysqli_select_db($login,'bus_system')){
                        //data field
                        $email=$_POST['email'];
                        $username=$_POST['username'];
                        $password=$_POST['password'];
                        $confirmPassword=$_POST['repeatPassword'];
                        $isValid = true;

                        /*
                        ------validation-------
                        */
                        if(!validateEmail($email))
                            $isValid = false;

                        if(!validateUsername($username))
                            $isValid = false;

                        if(!validatePassword($password))
                            $isValid = false;
                        
                        if($password != $confirmPassword){
                            echo "<p>The repeat password should be same as the password.</p>";
                            $isValid = false;
                        }

                        //check all set
                        if($isValid){

                            $querySQL="INSERT INTO user(userId,username,userpassword,email)
                                        VALUES(0,'$username','$password','$email')";

                            //if all success insert
                            if(mysqli_query($login,$querySQL)){
                                echo"<p>You had Register sucessfully</p>";
                                echo"<a href='login.php'>Go to login</a>";
                            }

                            else{
                                echo"<p style='color:red;'> Unsuccessful register entry
                                        into database because of:>".mysqli_error($login).
                                        "The query was:" .$querySQL. "</p>";
                            }
                        }
                    }
                    else{
                        die("<p>Error creating database:" .mysqli_error($login). "</p>");
                    }

                    //close connection
                    mysqli_close($login);

                }else{
                    die('Could not connect: '.mysqli.error($login));
                }

                
                
                
            }

            else{
                //html and php display code
        ?>


            <h2>Sign Up</h2>
            <form method="post" action="">
                <p>Have an account? <a href="../webpage/login.php">Login</a></p>
                <label for='email' class="form-label"><b>Email</b></label>
                <input type='text' placeholder='Enter Email' name='email' required></input>
                <br><br>

                <label for='uname' class="form-label"><b>Username</b></label>
                <input type='text' placeholder='Enter Username' name='username' required></input>
                <br><br>

                <label for='psw' class="form-label"><b>Password</b></label>
                <input type='password' placeholder='Enter Password' name='password' required></input>
                <br><br>

                <label for='repsw' class="form-label"><b>Repeat Password</b></label>
                <input type='password' placeholder='Repeat Password' name='repeatPassword' required></input>

                <p>By sign up, you agree to Speedy Bus's <a href="../webpage/privacyPolicy.php">Terms & Privacy</a></p>
                <input type='submit' class='signupbtn' value="Register">
                <input type="reset" class='cancelbtn' value="Cancel">
                <input type="hidden" name="submitted" value="true">
                
            </form>
        <?php } ?>
        </div>

        <?php
            include("../webpage/footer.html");
        ?>
	</body>
</html>
