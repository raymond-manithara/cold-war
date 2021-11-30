<?php
    session_start();
    if(isset($_SESSION["userId"])&&isset($_SESSION["username"])){
        header("location:admin_page.php");
    }
    require_once './connection.php';
    if(isset($_POST["signin"])){
        $username = $_POST["Uname"];
        $password = $_POST["Pass"];
        $password = md5($password);
        $query = "SELECT UserId FROM registration WHERE Email = '$username' AND Password = '$password' ";       
        $result = mysqli_query($conn,$query);
        $rows = mysqli_num_rows($result);
        if($rows>0)
       {
           foreach ($result as $r) {
            $_SESSION["userId"] = $r['UserId'];
           }
           $_SESSION["username"] = $username;
           header("location:admin_page.php");
       }
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #555555;
            font-family: 'Arial';
            display: flex;
            justify-content: center;
        }

        .login {
            width: 300px;
            overflow: hidden;
            margin: auto;     
            padding: 80px;
            background: #EEEEEE;
            border-radius: 15px;
            margin-top: 15%;
            display: inherit;
            justify-content: center;

        }

        h2 {
            text-align: center;
            color: #277582;
            padding: 20px;
        }

        label {
            color: #000;
            font-size: 17px;
        }

        #Uname {
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 3px;
            padding-left: 8px;
        }

        #Pass {
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 3px;
            padding-left: 8px;

        }

        #log {
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 10px;
            padding-left: 7px;
            color: #FFFFFF;
            background-color: #333333;


        }

        span {
            color: white;
            font-size: 17px;
        }

        a {
            float: right;
            background-color: grey;
        }
    </style>
</head>

<body>
    <div class="login">
        <form id="login" method="post" action="">
            <label><b>Username
                </b>
            </label>
            <input type="text" name="Uname" id="Uname" placeholder="Username">
            <br><br>
            <label><b>Password
                </b>
            </label>
            <input type="Password" name="Pass" id="Pass" placeholder="Password">
            <br><br>
            <input type="submit" name="signin" id="log" value="Sign In">
            <br><br>
        </form>
    </div>
</body>

</html>