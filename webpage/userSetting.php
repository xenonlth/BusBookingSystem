<html lang="en">
	<head>
		<title>User Settings</title>
		<?php include("../webpage/headinclude.html"); ?>
        <style>
            #content{
                padding:50px 200px;
            }
        </style>
	</head>

	<body id="main">
        <?php
            include('../webpage/webpageSetting.php');
            include('../scripts/commonFunction.php');
            include('../webpage/header.php'); 
        ?>
    
        <div id="content">
        <?php
            if(isset($_POST['submitted'])){
                setcookie('language',$_POST['language']);
                setcookie('state',$_POST['state']);
                setcookie('bgcolor',$_POST['bgcolor']);
                echo "<center>Your setting had been saved!</center>";
                returnToHomepage();
            }
            else{
        ?>
            <form method="post" action="userSetting.php">
                <h2>User Settings</h2>
                <h3>Language:</h3>
                <select name="language">
                    <option value="">Language</option>
                    <?php
                        $languages = array("Chinese","Spanish","English","Hindi","Bengali",
                                        "Portuguese","Russian","Japanese","Korean","Frances");
                    
                        foreach($languages as $row){
                            echo "<option value=\"$row\">$row</option>";
                        }
                    ?>
                </select>
                <br><br>
                
                <h3>State:</h3>
                <select name="state">
                    <option value="">State</option>
                    <?php
                        $states = array("Perlis","Kelantan","Kedah","Penang","Pahang",
                                        "Selangor","Kuala Lumpur","Puchong","Melaka","Terengganu","Johor","Sabah","Sarawak");
                    
                        foreach($states as $row){
                            echo "<option value=\"$row\">$row</option>";
                        }
                    ?>
                </select>
                <br><br>

                <h3>Background Color:</h3>
                <select name="bgcolor">
                    <option value="">Background Color</option>
                    <?php 
                        $colors = array("Default","Black","White","Red","Yellow","Orange","Blue","Green");
                        
                        foreach($colors as $row){
                            echo "<option value=\"$row\">$row</option>";
                        }
                    ?>
                </select>
                <br/><br/>
                
                <button type='submit'>Submit</button>
                <input type="hidden" name="submitted" value="true"/>
            </form>
        <?php }?>
        </div>

	    <?php include('../webpage/footer.html'); ?>
	</body>
</html>