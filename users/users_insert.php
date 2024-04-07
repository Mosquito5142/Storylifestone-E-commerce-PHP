<?php
include "../config.php";
$user_tel = $_POST["user_tel"];
$user_email = $_POST["user_email"];
$user_name = $_POST["user_name"];
$user_password = $_POST["user_password"];
$user_password = md5($user_password);
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("error" . mysqli_connect_error());
}
$sql = "INSERT INTO users (user_name,user_tel,user_email,user_password)
        VALUES('$user_name','$user_tel','$user_email','$user_password')";
if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Successful</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .loader {
                width: 60px;
                aspect-ratio: 4;
                background: radial-gradient(circle closest-side, #000 90%, #0000) 0/calc(100%/3) 100% space;
                clip-path: inset(0 100% 0 0);
                animation: l1 1s steps(4) infinite;
            }
            .checkmark {
                font-size: 40px;
                color: #4CAF50;
            }
            @keyframes l1 {
                to {
                    clip-path: inset(0 -34% 0 0);
                }
            }
        </style>
    </head>
    <body>
        <div class="checkmark">&#10004;</div>
        <p> สมัครสำเสร็จ</p>
        <script>
            setTimeout(function() {
                window.location.href = "login.php";
            }, 3000); // Redirect after 3 seconds (adjust as needed)
        </script>
    </body>
    </html>
    <?php
} else {
    echo "Error" . mysqli_error($conn);
    mysqli_close($conn);
}
?>
