<?php
session_start(); 
include 'dbconnect.php';

$message = "";
$toastClass = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST['username']) || empty($_POST['password'])){
        $message = "Username and password are required.";
        $toastClass = "#831d38c5";
    }else{
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(strlen($password) < 8){
            $message = "Password must be at least 8 characters.";
            $toastClass = "#831d38"; 
        }else{
            $checkUsernameExist = $conn->prepare("SELECT username FROM users WHERE username = ?");
            $checkUsernameExist->bind_param("s", $username);
            $checkUsernameExist->execute();
            $checkUsernameExist->store_result();

            if($checkUsernameExist->num_rows > 0){
                $message = "Username already exists";
                $toastClass = "#007bff";
            }else{
                // hash password biar keren pas disimpen eak eak
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashedPassword);

                if($stmt->execute()){
                    $_SESSION['registration_success'] = true;
                    $message = "Account created successfully";
                    $toastClass = "#6e8e59";
                    header("Location: login.php");
                    exit();
                }else{
                    $message = "Error: " . $stmt->error;
                    $toastClass = "#831d38";
                }
                $stmt->close();
            }
            $checkUsernameExist->close();
        }
    }
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: rgb(234, 250, 234)
    }
    .wrapper{
        width: 420px;
        background:  #dff3d3;
        border: 2px solid #99c0a4;
        border-radius: 10px;
        padding: 30px 40px;
    }
    .wrapper h1{
        color: #6E8E59;
        font-weight: 600;
        font-size: 36px;
        text-align: center;
    }
    .wrapper .loginbox{
        position: relative;
        width: 100%;
        height: 50px;
        margin: 30px 0;
    }
    .loginbox input{
        width: 100%;
        height: 100%;
        background: transparent;
        border: none;
        outline: none;
        border: 2px solid #99c0a4;
        border-radius: 40px;
        font-size: 16px;
        color: white;
        padding: 20px 45px 20px 20px;
    }
    .loginbox input::placeholder{
        color:#6E8E59;
    }
    .loginbox i{
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
    }
    .wrapper .btn{
        width: 100%;
        height: 45px;
        background: transparent;
        border: 2px solid #6E8E59;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #6E8E59;
        font-weight: 600;
    }
    .wrapper .btn:hover{
        width: 100%;
        height: 45px;
        background:#831d38;
        border: 2px solid #CAE0BC;
        outline: none;
        border-radius: 40px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        cursor: pointer;
        font-size: 16px;
        color: #CAE0BC;
        font-weight: 600;
    }
    .wrapper .register{
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
    }
    .register p{
        color: #6E8E59;
    }
    .register p a{
        color: #831d38c5;
        text-decoration: none;
        font-weight: 600;
    }
    .register p a:hover{
        text-decoration: underline;
    }
    .bx.bxs-user {
        color: #6E8E59;
    }
    .bx.bxs-lock-alt {
        color: #6E8E59;
    }
    .product{
        color: #831d38c5;
    }
    .loginbox .input{
            color: #6E8E59;
        }
    </style>
<body>
    <div class="wrapper">
        <h1>Be a <span class="product">Bookeeper!</span></h1>
        <!-- ini juga error message -->
        <?php if ($message): ?>
            <div class="toast align-items-center text-white border-0"
                style="background: <?php echo $toastClass; ?>;"
                role="alert"
                aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <!-- yeah form -->
        <form action="" method="post">
            <div class="loginbox">
                <input class="input" name="username" type="text" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="loginbox">
                <input class="input" name="password" type="password" placeholder="Password" required minlength="8">
                <i class='bx bxs-lock-alt' ></i>
            </div>
                <button type="submit" class="btn">Sign up</button>
                </form>
            <div class="register">
                <p>Already a Bookeper? <a href="login.php">Log in</a></p>
            </div>
    </div>
    <!-- script toast lagi -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            let toastElList = [].slice.call(document.querySelectorAll('.toast'));
            let toastList = toastElList.map(function (toastEl){
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });
        toastList.forEach(toast => toast.show());
        });
    </script>
</body>
</html>