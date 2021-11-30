<?php
    require_once './connection.php';

    if($conn){
        // echo "<script>
        // alert('Connection Success!');
        // </script>";
    }
    if(isset($_POST["submit"])){
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $team = $_POST["team"];
        $query = "INSERT INTO `catering` (`OrderId`,`Name`,`Phone`,`Address`,`Date`,`Time`,`Team`) VALUES (0,'$name','$phone','$address','$date','$time','$team')";
        echo $query;
        if (mysqli_query($conn,$query)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
    }
?>
<html>
    <head>
        <style>
            .input-container{
                display: "flex";
                flex-direction: "column";
            }
        </style>
    </head>
    <body>
        <form method="post" action="">
            <div class="input-container">
                <input type="text" name="name" id="name" placeholder= "Name"/>
                <input type="text" name="phone" id="phone" placeholder= "Phone"/>
                <input type="text" name="address" id="address" placeholder= "Address"/>
                <input type="text" name="date" id="date" placeholder= "Date"/>
                <input type="text" name="time" id="time" placeholder= "Time"/>
                <input type="text" name="team" id="team" placeholder= "Team"/>
                <input type="submit" name="submit" id="submit" value = "Save Order"/>
            </div>   
        </form>
    </body>
</html>