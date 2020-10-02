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
                echo "<li><a href=\"../webpage/login.php\" class=\"header-typeB\"><p>Sign In/Register</p></a></li>";
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