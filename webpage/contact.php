<!DOCTYPE html>
<html lang = "en">

    <head>
        <title>Speedy Bus | Contact Us</title>
        <?php include("../webpage/headinclude.html");?>
    </head>

    <body id="main">
        <?php 
            include('../webpage/webpageSetting.php');
            include('../scripts/commonFunction.php');
            include("../webpage/header.php"); 
        ?>

        <div id="content">
            <center>
                <h2>Contact us</h2>

                <table border = "9" width = "70%" class="whiteBackground">
                    <tr>
                    <th>Email:</th>
                    <td><a href = "mailto:speedybus@gmail.com">speedybus@gmail.com</a></td>
                    </tr>

                    <tr>
                    <th rowspan = "2">Phone:</th>
                    <td>04-579 8116</td>
                    </tr>

                    <td>011 - 0403 0714</td>
                    </tr>

                    <tr>
                    <th>Address:</th>
                    <td>Level 25, Menara Worldwide 198 Jalan Bukit Bintang, 55100 Kuala Lumpur, Malaysia</td>
                    
                    <tr>
                    <th>Facebook</th>
                    <td><a href = "www.facebook.com">www.facebook.com</a></td>
                    </tr>
                    
                    <tr>
                    <th>Instagram</th>
                    <td><a href = "www.instagram.com">www.instagram.com</a></td>
                    </tr>
                    
                    <tr>
                    <th>Twitter</th>
                    <td><a href = "www.twitter.com">www.twitter.com</a></td>
                    </tr>
                </table>
            </center>

            <br>

            <hr>

            <h4>Speedy Bus Ticket Booking Website would like to hear from you as for feedback 
            is valuable to us for further improvement and to provide better service.<br>

            Kindly fill up the details below and we will respond as soon as possible. Thank you.</h4>

            <?php
                if(isset($_POST['submitted'])){

                    //login data base
                    if($login = mysqli_connect('localhost','root','')){
                        //if no database found
                        if(mysqli_select_db($login,'bus_system')){
                            //data field
                            $email=$_POST['email'];
                            $first_name=$_POST['fname'];
                            $last_name=$_POST['lname'];
                            $gender=$_POST['gender'];
                            $phone_number=$_POST['phone'];
                            $respond_type = $_POST['respondType'];
                            $feedback=$_POST['feedback'];
                            $isValid = true;

                            /*
                                ----validations-------
                            */
                            if(!validateEmail($email))
                                $isValid = false;
                            
                            if(!validateAlphabet($first_name,"First name"))
                                $isValid = false;

                            if(!validateAlphabet($last_name,"Last name"))
                                $isValid = false;

                            if(!checkEmpty($gender,"Gender"))
                                $isValid = false;

                            if(!validatePhone($phone_number))
                                $isValid = false;

                            if(!checkEmpty($respond_type,"Respond type"))
                                $isValid = false;
                            
                            if(!checkEmpty($feedback,"Feedback"))
                                $isValid = false;

                            //check all set
                            if($isValid){

                                $querySQL="INSERT INTO contactResponse(responseId,email,firstName,lastName,gender,phoneNumber,respondType,feedback)
                                            VALUES(0,'$email','$first_name','$last_name','$gender','$phone_number','$respond_type','$feedback')";

                                //if all success insert
                                if(mysqli_query($login,$querySQL)){
                                    echo"<p>Submit sucessfully</p>";
                                    echo"<a href='home.php'>Back to main page</a>";
                                }

                                else{

                                    echo"<p style='color:red;'> Unsuccessful register entry
                                            into database because of:>".mysqli_error($login).
                                            "The query was:" .$querySQL. "</p>";
                                    returnToHomepage();
                                }
                            }else{
                                echo "<p>Failed to submit the form. Please try again later.</p>";
                                returnToHomepage();
                            }

                        }else{
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
                <form method="post" action="contact.php">
                    <fieldset>
                        <legend><h3>Personal Information:</h3></legend>
                        <label for="fname" class="form-label">First name:</label>
                        <input type="text" id="fname" name="fname">
                    
                        <label for="lname" class="form-label">Last name:</label>
                        <input type="text" id="lname" name="lname"><br><br>
                    
                        <label for="gender" class="form-label">Gender:</label>
                        <input type="radio" id="gender-male" name="gender" value="male">
                        <label for="male" class="form-label">Male</lable>
                        <input type="radio" id="gender-female" name="gender" value="female">
                        <label for="male" class="form-label">Female</lable><br><br>
                    
                        <label for="phone" class="form-label">Phone number:</label>
                        <input type="tel" id="phone" name="phone" placeholder="012-3456789" pattern="[0-9]{3}-[0-9]{7}"><br><br>
                    
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email"><br><br>

                        <label for="respondType" class="form-label">Respond Type:</label>
                        <input type="radio" id="respondType-phone" name="respondType" value="phone">
                        <label for="choice_phone" class="form-label">Phone Number</lable>
                        <input type="radio" id="respondType-email" name="respondType" value="email">
                        <label for="choice_email" class="form-label">Email</lable><br><br>
                    </fieldset>
                
                    <br>
                
                    <fieldset>
                        <legend><h3>Feedback:</h3></legend>
                        <label for = "feedback" class="form-label">Tell us your feedback and comment:</label><br><br>
                        <textarea id = "feedback" name = "feedback" rows="13" cols="70" placeholder = "Write Something..."></textarea><br><br>
                    
                        <input type="submit" value="Submit">
                        <input type="hidden" name="submitted" value="true">
                    </fieldset>
                </form>
            <?php } ?>
        </div>

        <?php
            include("../webpage/footer.html");
        ?>
    </body>
</html>