<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Speedy Bus | Login</title>
        <?php include("../webpage/headinclude.html");?>
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
                        echo "<li><a href=\"../webpage/register.php\" class=\"header-typeB\"><p>Register</p></a></li>";
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
                if(!empty($uname)){
                    echo "<center>";
                    if(isset($_POST['logoutSubmit'])){
                        unset($_SESSION);
                        session_destroy();
                        echo "<p>You had Log out successfully.</p>";
                        returnToHomepage();
                    }
                    else{
                        echo "<h2> Do you want to Log out?</h2>";
                        echo "<p>Hi $uname, you had login since $loginTime</p>";
                        echo "<p>Click the button below to log out</p>";
                        echo "<form action=\"login.php\" method=\"post\">";
                        echo "<input type=\"submit\" value=\"log out\">";
                        echo "<input type=\"hidden\" name=\"logoutSubmit\" value=\"true\">";
                        echo "</table>";
                    }
                    echo "</center>";
                }
                else{


                    if(isset($_POST['submitted'])){
                        //handle the value of login form
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $isValid=TRUE;
                        
                        //Show alert message when username had no entry
                        if(!checkEmpty($username,"Username"))
                            $isValid = false;
                        //Show alert message when password had no entry
                        if(!checkEmpty($password,"Password"))
                            $isValid = false;

                        //If every valid is true, show a success message
                        if($isValid){

                            if($db = mysqli_connect('localhost','root','')){
                                if(mysqli_select_db($db,'bus_system')){
                                    $querySQL="SELECT * FROM user  WHERE username='$username' && userpassword ='$password'";
                                    $result= mysqli_query($db,$querySQL);
                                    
                                    //equals 1 if user found
                                    if(!empty($result) && mysqli_num_rows($result)==1){
                        
                                        //store username
                                        $_SESSION['uname'] = $username;
                                        //store login time
                                        date_default_timezone_set("Asia/Kuala_Lumpur");
                                        $_SESSION['loginTime'] = date("y-m-d : h:m:sA");

                                        if(isset($_POST['remember'])){
                                            setcookie("rememberUsername",$username);
                                            setcookie("rememberPassword",$password);
                                            setcookie("remember",true);
                                        }else{
                                            setcookie("rememberUsername","");
                                            setcookie("rememberPassword","");
                                            setcookie("remember","");
                                        }
                                        echo "<center>";
                                        print "Hi,$username,You have been login successfully since ".date("y-m-d : h:m:sA");
                                        echo "</center>";
                                        returnToHomepage();
                                    }
                        
                                    else{
                                        echo"<p> User Not Found, please sign up or try again later!</p>";
                                        returnToHomepage();
                                    }
                                }else{
                                    die('Could not connect: '.mysqli_error($db));
                                    returnToHomepage();
                                }
                                //close connection
                                mysqli_close($db);
                            }else{
                                die('Could not connect: '.mysqli_error($db));
                                returnToHomepage();
                            }
                        }
                    }
                    else{
                        //login html at below
                ?>
                <h2>Login</h2>
                <form method="post" action="login.php">
                    <label for='username' class="form-label"><b>Username</b></label>
                    <input type='text' placeholder='Enter Username' name='username' 
                        <?php echo !empty($_COOKIE['rememberUsername'])?"value=\"".$_COOKIE['rememberUsername']."\"":"" ?>
                    required></input>
                    <br><br>

                    <label for='password' class="form-label"><b>Password</b></label>
                    <input type='password' placeholder='Enter Password' name='password'
                        <?php echo !empty($_COOKIE['rememberPassword'])?"value=\"".$_COOKIE['rememberPassword']."\"":"" ?>
                    required></input>
                    <br><br>

                    <input type='submit' value="Login">
                    <input type="hidden" name="submitted" value="true">
                    <label>
                        <input type='checkbox' 
                            <?php echo isset($_COOKIE['remember'])?"checked=\"checked\"":"" ?> 
                        name='remember'>Remember me</input>
                    </label>
                    <p>By Login, you agree to Speedy Bus's <a href="../webpage/privacyPolicy.php">Terms & Privacy</a></p>
                    <p>New to Speedy Bus? <a href="../webpage/register.php">Click Here to Sign Up</a></p>
                </form>
            <?php 
                }
            } 
            
            ?>
        </div>

        <?php
            include("../webpage/footer.html");
        ?>
	</body>
</html>
