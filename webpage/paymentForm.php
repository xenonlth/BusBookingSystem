<!DOCTYPE html>
<html lang="en">
<head>
	<title>Speedy Bus | Purchase Method</title>
	<?php include("../webpage/headinclude.html");?>
</head>

<body id="main">
	<div id="content">
	<?php 
		include('../webpage/webpageSetting.php');
		include('../scripts/commonFunction.php');
		include("../webpage/header.php"); 
	?>

	<?php
		if(isset($_POST['submitted'])){
			
			//data field
			$payment_method=$_POST['paymentMethod'];
			$first_name=$_POST['firstName'];
			$last_name=$_POST['lastName'];
			$card_no=$_POST['cardNo'];
			$expire_date=$_POST['expireDate'];
			$cvv=$_POST['cvv'];
			$total_pay=$_POST['totalPrice'];
			//next time user login check purchase history, use this username to match
			$travel_date=$_POST['travelDate'];
			$total_pax=$_POST['numPax'];
			$ticket_type=$_POST['type'];
			$isValid = true;

			/*
			validations
			*/
			if(!validateAlphabet($first_name,"First Name"))
				$isValid = false;
			
			if(!validateAlphabet($last_name,"Last Name"))
				$isValid = false;

			if(!checkEmpty($payment_method,"Payment Method"))
				$isValid = false;

			if(!checkEmpty($card_no,"Card Number"))
				$isValid = false;

			if(!checkEmpty($cvv,"CVV"))
				$isValid = false;

			if(!checkEmpty($expire_date,"Expire Date of the card"))
				$isValid = false;

			if(!checkEmpty($total_pax,"Total number of person"))
				$isValid = false;
			
			
			
			if(!checkEmpty($travel_date,"Travel Date"))
				$isValid = false;
			
			if(!checkEmpty($ticket_type,"Ticket Type"))
				$isValid = false;
			
			if($ticket_type=="oneway_ticket"||$ticket_type=="roundtrip_ticket"){
                                $busId=$_POST['busId'];
				if(!checkEmpty($busId,"Bus"))
				        $isValid = false;
			}else{
                                $busId = 0;
			}
			
			
			//check all set
			if($isValid){

				//login data base
				if($login = mysqli_connect('localhost','root','')){
					//if no database found
					if(mysqli_select_db($login,'bus_system')){


						$search = "SELECT userId FROM user WHERE username = $uname";
						$data = mysqli_query($login,$search);
						if(!empty($data)){
							$row = mysqli_fetch_array($data);
							$userId = $row['userId'];
						}else{
							$userId = 0;	
						}

						$search = "SELECT ticketId FROM tickets WHERE ticketType = $ticket_type";
						$data = mysqli_query($login,$search);
						   if(!empty($data)){
							$row = mysqli_fetch_array($data);
							$ticketId = $row['ticketId'];
						   }else{
							$ticketId = 0;	   
						   }


						$querySQL = "INSERT INTO payment_record(paymentId,userId,firstName,lastName,paymentMethod,
										cardNo,busId,travelDate,ticketId,numPax,totalPrice)
										VALUES(0,$userId,\"$first_name\",\"$last_name\",\"$payment_method\",\"$card_no\",
										$busId,\"$travel_date\",$ticketId,$total_pax,$total_pay)";
					
						//if all success insert
						if(mysqli_query($login,$querySQL)){
							echo"<p>Purchase had been completed sucessfully.</p>";
							returnToHomepage();
						}

						else{

							echo"<p style='color:red;'> Unsuccessful register entry
									into database because of:>".mysqli_error($login).
									"The query was:" .$querySQL. "</p>";
						}

						
					}else{
						echo"<p>Error creating database:" .mysqli_error($login). "</p>";
						returnToHomepage();
					}

					mysqli_close($login);

				}else{
					die('Could not connect: '.mysqli.error($login));
					returnToHomepage();
				}

				
			}
			
		}
		else{
			//next time user login check purchase history, use this username to match
			$total_pax=$_POST['numPax'];
			$ticket_type=$_POST['type'];
			$month = $_POST['month'];
			$day = $_POST['day'];
			$state = $_POST['state'];
			$area = $_POST['area'];
			$station = $_POST['station'];
			$type = $_POST['type'];


			if($db = mysqli_connect("localhost","root","")){
				if(mysqli_select_db($db,"bus_system")){

					$query = "SELECT * FROM tickets WHERE ticketType='$type'";
					$ticketData = mysqli_fetch_array(mysqli_query($db,$query));

					echo "
						<form action=\"paymentForm.php\" method=\"post\">
						<div id=\"content\">
						<h2>Purchase Method</h2>
							<fieldset>
							<table spacing=\"3\">
							<tr>
								<h3>Order Detail</h3>
							</tr>

							<tr>
								<td><b>Ticket type</b></td>
								<td><input type=\"text\" name=\"type\" value=\"$type\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Travel Date</b></td>
								<td><input type=\"text\" name=\"travelDate\" value=\"$month\" readonly></td>
							</tr>";
					
					
					if($type == "monthly_ticket"){
						echo "<tr>
								<td><b>State</b></td>
								<td><input type=\"text\" name=\"departure\" value=\"$state\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Travel Date</b></td>
								<td><input type=\"text\" name=\"travelDate\" value=\"$month - $day\" readonly></td>
							</tr>
							
							<tr>
								<td><b>No.of Pax</b></td>
								<td><input type=\"text\" name=\"numPax\" value=\"$total_pax\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Ticket price per pax</b></td>
								<td><input type=\"text\" name=\"ticket_price\" value=\"".$ticketData['price']."\" readonly></td>
							</tr>
							
							</table>
						</fieldset>";
					}
					else if($type == "daily_ticket"){
						echo "<tr>
								<td><b>State</b></td>
								<td><input type=\"text\" name=\"departure\" value=\"$state\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Date</b></td>
								<td><input type=\"text\" name=\"travelDate\" value=\"$month - $day\" readonly></td>
							</tr>
							
							<tr>
								<td><b>No.of Pax</b></td>
								<td><input type=\"text\" name=\"numPax\" value=\"$total_pax\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Ticket price per pax</b></td>
								<td><input type=\"text\" name=\"ticket_price\" value=\"".$ticketData['price']."\" readonly></td>
							</tr>
							
							</table>
						</fieldset>";
					}
					else if($type == "oneway_ticket" || $type== "roundtrip_ticket"){
						$busId=$_POST['busId'];

						$query = "SELECT * 
							FROM bus_schedule b,station_list s 
							WHERE b.stationId = s.stationId && b.busId = $busId";

						$data = mysqli_fetch_array(mysqli_query($db,$query));

						echo "<tr>
								<td><b>Departure</b></td>
								<td><input type=\"text\" name=\"departure\" value=\"$state - $area - $station\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Travel Date</b></td>
								<td><input type=\"text\" name=\"travelDate\" value=\"$month - $day\" readonly></td>
							</tr>
							
							<tr>
								<td><b>Departure Time</b></td>
								<td><input type=\"text\" name=\"departure\" value=\"".$data['b.timeTravel']."\" readonly></td>
							</tr>
							
							<tr>
								<td><b>No.of Pax</b></td>
								<td><input type=\"text\" name=\"numPax\" value=\"$total_pax\" readonly></td>
							</tr>";
							
						printf("<tr>
								<td><b>Ticket price per pax</b></td>
								<td><input type=\"text\" name=\"ticket_price\" value=\"$.2f\" readonly></td>
							</tr>
							        <input type=\"hidden\" name=\"busId\" value=\"$busId\">
							</table>
						</fieldset>",$ticketData['price']);
					}else{
						returnToHomepage();
					}
					
						
				echo	"<br>	
					<table spacing=\"3\">
					<h3>Your order</h3>
					
					<tr>
						<td><b>First name:</b></td>
						<td><input type=\"text\" name=\"firstName\"></td>
					</tr>
					
					<tr>
						<td><b>Last Name:</b></td>
						<td><input type=\"text\" name=\"lastName\"></td>
					</tr>
					
					<tr>
						<td><b>Payment method:<b></td>
						<td><select name=\"paymentMethod\">
						<option value=\"visa\">Visa</option>
						<option value=\"master\">Master</option>
						<option value=\"americanExpress\">American Express</option>
						</td>
					</tr>
					
					
					<tr>
						<td><b>Card no:<b></td>
						<td><input type=\"text\" name=\"cardNo\"></td>
					</tr>
					
					<tr>
						<td><b>Expire date:</b></td>
						<!-- After will replace with for loop, using for loop to dropdown list for user selection-->
						<td><input type=\"text\" name=\"expireDate\"></td>
					</tr>
					
					
					<tr>
						<td><b>CVV/Security code:</b></td>
						<td><input type=\"text\" name=\"cvv\"></td>
					</tr>
					
					<tr>
						<td><b>Total Payable:</b></td>
						<td><input type=\"text\" name=\"totalPrice\" value=\"".((float)($ticketData['price'])*(int)($total_pax))."\" readonly></td>
					</tr>
					
					
					</table>
					</fieldset>

					<br>
					<input type=\"submit\" value=\"Submit\">
					<input type=\"reset\" value=\"Reset\">
					<input type=\"hidden\" name=\"submitted\" value=\"true\">
					
					</form>";

				}else{
					echo"<p>Error creating database:" .mysqli_error($login). "</p>";
					returnToHomepage();
				}

				mysqli_close($db);
			}else{
				die('Could not connect: '.mysqli.error($login));
				returnToHomepage();
			}
		} 
	?>

	</div>
	<?php
		include("../webpage/footer.html");
	?>
</body>
</html>
