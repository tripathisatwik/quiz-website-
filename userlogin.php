<html>

<head>
    <title>User Login</title>
    <style>
        /* userlogin.css */

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
        }

        .extra {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 1rem;
        }

        .outer {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 300px;
        }

        .userlogin h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .userlogin p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .userlogin input[type="text"],
        .userlogin input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
        }

        .userlogin input[type="submit"] {
            width: 70%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .userlogin input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .usersignup {
            text-align: center;
            margin-top: 20px;
        }

        .usersignup img {
            paddding: 20px;
            max-width: 100px;
            max-height: 100px;
            margin-bottom: 10px;
        }

        .usersignup h3 a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .usersignup h3 a:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="extra">
        <div class="outer">
            <div class="userlogin">
                <form action="" method="POST">
                    <h2>LOGIN</h2>
                    <p>Enter your Username and Password</p>
                    USERNAME <br> <input type="text" name="username" placeholder="Enter your Username">
                    <br>
                    PASSWORD <br> <input type="password" name="password">
                    <br>
                    <input type="submit" name="submit" value="LogIn"
                        style="font-size:20px; background-color:blue; color:white; text-align:center; border=0; border-radius:5px;">

                </form>
            </div>
            <div class="usersignup">
                <img src="12.jpg" alt="User">
                <h3><a href="signup.php">Don't have Any Account?</a></h3>
            </div>
        </div>
    </div>

    <?php
    include 'dbconnect.php';
    session_start();
    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "select * from user where Username='$username' and Password='$password'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);

        if ($num == 1) {
            $_SESSION['Login_session'] = $username;
            echo "Login Sucess";
            header("Location:http://localhost/Project/quiz.php");

        } else {
            echo "invalid username or password";
        }
    }
    ?>

</body>

</html>