<?php 
session_start();
include 'dbconnect.php';

$query = "SELECT * FROM books WHERE user_id = " . $_SESSION['user_id'];
$connectQuery = mysqli_query($conn, $query);

if(!isset($_SESSION['user_id'])){
    die("User not logged in. Please log in.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<style>
        body{
            background: #EAFAEA;
        }
        nav{
            background-color: #dff3d3;
            width: 100%;
            height: 55px;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
        }
        nav a{
            height: 100%;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 20px;
        }

        .logo{
            font-size: 25px;
            font-weight: bold;
            color: #831d38c5;
            padding-top: 15px;
            padding-left: 1.5%;
            padding-bottom: 21px;
            justify-content: center;
        }
        nav .logout{
            background-color: #6E8E59;
            color: #dff3d3;
            padding: 1rem 1rem;
            margin-right: 1.5%;
            border: none;
            outline: none;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 700;
            height: 25px;
            min-width: 85px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        nav .logout:hover{
            color:#831d38c5;
        }
        .container{
            margin-left: 4px;
            margin-top: 3px;
        }
        .container .btn{
            background-color:#CAE0BC;
            color: #831d38c5;
            border: none;
            padding: 7px 10px; 
            font-size: 16px; 
            font-family: 'Poppins';
            font-weight: 700;
            border-radius: 10px;
            cursor: pointer; 
        }
        .container .btn:hover{
            background-color: #831d38c5; 
            color: #CAE0BC;
        }
        .card_ctn{
            background-color: #CAE0BC;
            padding: 10px 20px;
            border-radius: 15px;
            margin-left: 16px;
            margin-top: 10px;
        }
        .card_ctn .btn-primary{
            background-color: #EAFAEA;
            border: none;
            color:#6E8E59;
            padding:  5px 20px 5px 20px; 
            font-size: 16px; 
            font-family: 'Poppins';
            font-weight: 500;
            border-radius: 10px;
        }
        .card_ctn .btn-danger{
            background-color: #831d38c5;
            border: none;
            color:#EAFAEA;
            padding: 5px 10px 5px 10px; 
            font-size: 16px; 
            font-family: 'Poppins';
            border-radius: 10px;
            font-weight: 500;
        }
        .btnbtn{
            display: flex;
            justify-content: space-between;
        }
        .card-title{
            color: #6E8E59;
            font-weight: bold;
        }
        .card-text{
            font-weight: bold;
            color: #6E8E59;
        }
        .card-text .desc{
            font-weight: 500;
        }
        .card-container{
            display: flex;
            flex-wrap: wrap; 
            gap: 1px; 
            align-items: stretch;
        }
        .card_ctn{
            display: flex;
            flex-direction: column;
            width: 18rem; 
        }
        .card_ctn img{
            aspect-ratio: 3/4; 
            object-fit: cover; 
            border-radius: 10px; 
        }
        .card-body{
            margin-top: auto;
        }
        footer{
            background-color: #dff3d3;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 0;
        }
        footer .footer_ctn{
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #6E8E59;
        }
        footer .footer_ctn a{
            color: #6E8E59;
            font-size: 24px;
            text-decoration: none;
        }
        span{
            color: #831d38c5;
        }
        footer .footer_ctn a:hover{
            color: #831d38c5;
        }
</style>
<body>
    <!-- navbar -->
     <div class="navbar">
         <nav>
            <a href="home.php" class="logo">Bookeeper</span>
            <a href="logout.php" class="logout" type="submit" onclick="return confirm('Leave Bookeeper? :(');">Logout</a>

         </nav>
     </div>
     <br><br>
     <!-- list -->

      <div class="container">
          <a href="addit.php" role="button" class="btn btn-primary">Add Books</a>
        </div>
        <!-- cards yippee -->
        <div class="card-container">
                 <?php 
                    while($result = mysqli_fetch_assoc($connectQuery)){
                 ?>
            <div class="card_ctn">
                <!-- sekrip -->
                <img src="img/<?php echo $result['photo']; ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">
                        <?php echo $result['name']; ?>
                    </h4>
                    <p class="card-text">
                        Author: <span class="desc"><?php echo $result['author']; ?></span><br>
                        Publisher: <span class="desc"><?php echo $result['publisher']; ?></span><br>
                        Pages: <span class="desc"><?php echo $result['number_of_page']; ?></span><br>
                    </p>
                    <div class="btnbtn">
                        <a href="addit.php?edit=<?php echo $result['user_id'] . '_' . $result['id']; ?>" class="btn btn-primary">Edit</a>
                        <a href="process.php?delete=<?php echo $result['user_id'] . '_' . $result['id']; ?>" role="button" class="btn btn-danger" onclick="return confirm('Delete this book?');">Delete</a>
                    </div>
                </div>
            </div>
                <?php  
                    }
                ?>
        </div>
    </div>
    <br>
    <!-- kaki -->
    <footer>
         <div class="footer_ctn">
             <div class="footer_dsc">
                <h6>Made by love by <span>Chelsea Alanna Fakhira</span></h6>
             </div>
            <div class="icons">
                <a href="https://instagram.com/chelsealcnna" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://github.com/chrysan95" target="_blank"><i class="fab fa-github"></i></a>
                <a href="https://linkedin.com/in/chelsealanna/" target="_blank"><i class="fab fa-linkedin"></i></a>
            </div>
         </div>
     </footer>
</body>
</html>