<?php 
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['user_id'])){
    die("User not logged in. Please log in.");
}

$editinBang = '';
$name = '';
$author = '';
$publisher = '';
$number_of_page = '';
$photo = '';

if(isset($_GET['edit'])){
    $editinBang = $_GET['edit'];
    list($user_id, $book_id) = explode('_', $editinBang); // ledakkan semuanya

    $query = "SELECT * FROM books WHERE id = $book_id AND user_id = $user_id";
    $connectQuery = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($connectQuery);

    $name = $result['name'];
    $author = $result['author'];
    $publisher = $result['publisher'];
    $number_of_page = $result['number_of_page'];
    $photo = $result['photo'];
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
        .col-sm-2{
            color: #6E8E59;
        }
        .form-control{
            color: #6E8E59;
        }
</style>
<body>
    <!-- navbar -->
     <div class="navbar">
         <nav>
            <a href="home.php" class="logo">Bookeeper</span>
            <a href="logout.php" class="logout" onclick="return confirm('Leave Bookeeper? :(');">Logout</a>
         </nav>
     </div>
     <br><br>
     <div class="container">
        <form method="post" action="process.php" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $user_id . '_' . $book_id; ?>" name="infoKoordinat">
          <div class="mb-3 row">
              <label class="col-sm-2 col-form-label"style="font-weight:bolder">Title</label>
              <div class="col-sm-10">
                  <input required type="text" class="form-control" name='name' id="name" value="<?php echo $name;?>">
              </div>
          </div>
          <div class="mb-3 row">
              <label class="col-sm-2 col-form-label"style="font-weight:bolder">Author</label>
              <div class="col-sm-10">
                  <input required type="text" class="form-control" name='author' id="author" value="<?php echo $author;?>">
              </div>
          </div>
          <div class="mb-3 row">
              <label class="col-sm-2 col-form-label"style="font-weight:bolder">Publisher</label>
              <div class="col-sm-10">
                  <input required type="text" class="form-control" name='publisher' id="publisher" value="<?php echo $publisher;?>">
              </div>
          </div>
          <div class="mb-3 row">
              <label class="col-sm-2 col-form-label"style="font-weight:bolder">Pages</label>
              <div class="col-sm-10">
                  <input required type="number" class="form-control" name='number_of_page' id="number_of_page" value="<?php echo $number_of_page;?>">
              </div>
          </div>
          <div class="input-group mb-3">
              <input type="file" class="form-control" id="inputGroupFile01" name='photo' id="photo" value="<?php echo $photo;?>">
            </div>
            <div class="banyakbtn">
                <!-- edit and add difference script -->
              <?php 
                if(isset($_GET['edit'])){
              ?>
                <button type="submit" value="edit" class="btn btn-primary" name="submit" onclick="return confirm('Save changes?');">Save</button>
              <?php 
                } else {
              ?>
                <button type="submit" value="add" class="btn btn-primary" name="submit" onclick="return confirm('Add this book to Bookeeper?');">Add</button>
              <?php 
                }
              ?>
              <a href="home.php" type="button" class="btn btn-secondary">Back</a>
            </div>
        </form>
     </div>
</body>
</html>