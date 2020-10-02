<?php

    if($db = mysqli_connect("localhost","root","")){
        while(!mysqli_select_db($db,"bus_system")){
            $query = "CREATE DATABASE bus_system";
            mysqli_query($db,$query);
        }

        //check the required table one by one
        $check = "SELECT * FROM user";
        
        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE user(
                        userId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                        username VARCHAR(40) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        userpassword VARCHAR(100) NOT NULL
                        )";
            if(mysqli_query($db,$create)){
                echo "Table user created successfully.<br>";
            }else{
                echo "Failed to create table user.".mysqli_error($db)."<br>";
            }

        }


        $check = "SELECT * FROM payment_record";

        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE payment_record(
                paymentId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                userId INT UNSIGNED NOT NULL,
                firstName VARCHAR(50) NOT NULL,
                lastName VARCHAR(50) NOT NULL,
                paymentMethod VARCHAR(10) NOT NULL,
                cardNo VARCHAR(20) NOT NULL,
                busId INT UNSIGNED NOT NULL,
                travelDate VARCHAR(30) NOT NULL,
                ticketId INT UNSIGNED NOT NULL,
                numPax INT UNSIGNED NOT NULL,
                totalPrice FLOAT UNSIGNED NOT NULL
                )";
            if(mysqli_query($db,$create)){
                echo "Table payment_record created successfully.<br>";
            }else{
                echo "Failed to create table payment_record.".mysqli_error($db)."<br>";
            }
        }


        

        $check = "SELECT * FROM station_list";

        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE station_list(
                stationId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                stationName VARCHAR(100) NOT NULL,
                stationArea VARCHAR(100) NOT NULL,
                stationState VARCHAR(100) NOT NULL
                )";
            if(mysqli_query($db,$create)){
                echo "Table station_list created successfully.<br>";
            }else{
                echo "Failed to create table station_list.".mysqli_error($db)."<br>";
            }
        }


        $check = "SELECT * FROM bus_schedule";

        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE bus_schedule(
                busId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                busNo VARCHAR(10) NOT NULL,
                dayTravel VARCHAR(15) NOT NULL,
                timeArrived TIME NOT NULL,
                stationId INT UNSIGNED NOT NULL
                )";
            if(mysqli_query($db,$create)){
                echo "Table bus_schedule created successfully.<br>";
            }else{
                echo "Failed to create table bus_schedule.".mysqli_error($db)."<br>";
            }
        }

        $check = "SELECT * FROM tickets";


        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE tickets(
                ticketId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                ticketType VARCHAR(30) NOT NULL,
                price FLOAT NOT NULL
                )";
            if(mysqli_query($db,$create)){
                echo "Table bus_schedule created successfully.<br>";
            }else{
                echo "Failed to create table bus_schedule.".mysqli_error($db)."<br>";
            }
        }

        $check = "SELECT * FROM contactResponse";

        if(mysqli_num_rows(mysqli_query($db,$check))==0){
            $create = "CREATE TABLE contactResponse(
                responseId INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
                email VARCHAR(100) NOT NULL,
                firstName VARCHAR(100) NOT NULL,
                lastName VARCHAR(100),
                gender VARCHAR(10) NOT NULL,
                phoneNo VARCHAR(20) NOT NULL,
                respondType VARCHAR(10) NOT NULL,
                feedback VARCHAR(1000) NOT NULL
                )";
            if(mysqli_query($db,$create)){
                echo "Table contactResponse created successfully.<br>";
            }else{
                echo "Failed to create table contactResponse.".mysqli_error($db)."<br>";
            }
        }


        $query = "INSERT INTO tickets(ticketId,ticketType,price) VALUES (0,'oneway_ticket',0.60)";
        mysqli_query($db,$query);
        $query = "INSERT INTO tickets(ticketId,ticketType,price) VALUES (0,'roundtrip_ticket',2.50)";
        mysqli_query($db,$query);
        $query = "INSERT INTO tickets(ticketId,ticketType,price) VALUES (0,'daily_ticket',3)";
        mysqli_query($db,$query);
        $query = "INSERT INTO tickets(ticketId,ticketType,price) VALUES (0,'monthly_ticket',25)";
        mysqli_query($db,$query);










        mysqli_close($db);
    }else{
        print("Failed to connect to database!".mysqli_error($db));
    }




?>
