<?php
	//read back the cookies and session in every page
	if(!empty($_COOKIE['language']))
		$language = $_COOKIE['language'];
	else
		$language = "English";
    
    if(!empty($_COOKIE['state']))
		$state = $_COOKIE['state'];
	else
		$state = "Penang";    
    
	if(!empty($_COOKIE['bgcolor']))
		$bgcolor = $_COOKIE['bgcolor'];
	else
		$bgcolor = "Default";
    
    
	session_start();
	if(!empty($_SESSION['uname']) && !empty($_SESSION['loginTime'])){
		$uname = $_SESSION['uname'];
        $loginTime = $_SESSION['loginTime'];
    }else{
        $uname = "";
    }
    
    if($bgcolor!=="Default"){
        echo "<style>
            #main{
                background:$bgcolor !important;
            }
            </style>";
    }
?>