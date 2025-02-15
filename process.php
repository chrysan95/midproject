<?php 
session_start();
include 'dbconnect.php';

    if(isset($_POST['submit'])){
        if($_POST['submit'] == "add"){
            if(!isset($_SESSION['user_id'])){
                die("User not logged in. Please log in.");
            }

            $name = $_POST['name'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $number_of_page = $_POST['number_of_page'];
            $user_id = $_SESSION['user_id'];

            if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){
                $photo = $_FILES['photo']['name'];
                $dir = "img/";
                $tmpFile = $_FILES['photo']['tmp_name'];

                $bolehAja = array("jpg", "jpeg", "png");
                $namaYangPernahAda = pathinfo($photo, PATHINFO_FILENAME);
                $namaKeluarga = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); // lower biar estetik

                if(in_array($namaKeluarga, $bolehAja)){
                    $newName = $namaYangPernahAda . $i . '.' . $namaKeluarga;
                    
                    for($i = 1; file_exists($dir.$newName); $i++){
                        $newName = $namaYangPernahAda . $i . '.' . $namaKeluarga;
                    }

                    if(move_uploaded_file($tmpFile, $dir.$newName)){
                        $photo = $newName;
                    } else {
                        echo "Error uploading photo.";
                        exit;
                    }
                } else {
                    echo "Only JPG, JPEG, and PNG are allowed.";
                    exit;
                }
            } else {
                $photo = "kocheng.jpg"; //kucing mmmmarah
            }        




            $query = "INSERT INTO books (name, author, publisher, number_of_page, user_id, photo)
                    VALUES('$name', 
                            '$author',
                            '$publisher',
                            '$number_of_page',
                            '$user_id',
                            '$photo')";
            $connectQuery = mysqli_query($conn, $query);

            if($connectQuery){
                header("location: home.php");
            } else {
                echo "Error adding books <a href='home.php'>[Home]</a>";
            } 
            
            
        } else if($_POST['submit'] == "edit"){

            if (!isset($_POST['infoKoordinat'])) {
                die("Missing record information.");
            }

            $infoKoordinat = $_POST['infoKoordinat'];
            list($user_id, $book_id) = explode('_', $infoKoordinat);

            $name = $_POST['name'];
            $author = $_POST['author'];
            $publisher = $_POST['publisher'];
            $number_of_page = $_POST['number_of_page'];

            $query = "UPDATE books SET name='$name',
                                       author='$author',
                                       publisher='$publisher',
                                       number_of_page='$number_of_page'";
            // ini nanti di append kalo ada foto yang diganti
            // wherenya diappend di bawah ifnya foto jadi ga eror walauupun gaada WHERE di query pertama
            
            if(isset($_FILES['photo']) && $_FILES['photo']['error'] === 0){
                $photo = $_FILES['photo']['name'];
                $dir = "img/";
                $tmpFile = $_FILES['photo']['tmp_name'];

                $bolehAja = array("jpg", "jpeg", "png");
                $namaYangPernahAda = pathinfo($photo, PATHINFO_FILENAME);
                $namaKeluarga = strtolower(pathinfo($photo, PATHINFO_EXTENSION)); // lower biar estetik

                if(in_array($namaKeluarga, $bolehAja)){
                    $newName = $namaYangPernahAda . $i . '.' . $namaKeluarga;
                    
                    for($i = 0; file_exists($dir.$newName); $i++){
                            if(!$i == 0){
                            $newName = $namaYangPernahAda . $i . '.' . $namaKeluarga;
                        }
                    }

                    if(move_uploaded_file($tmpFile, $dir.$newName)){
                        $query .= ", photo='$newName'";
                    } else {
                        echo "Error uploading photo.";
                        exit;
                    }
                } else {
                    echo "Only JPG, JPEG, and PNG are allowed.";
                    exit;
                }
            }

            $query .= " WHERE id = $book_id AND user_id = $user_id"; // masukin wherenya eak eak
            $connectQuery = mysqli_query($conn, $query);
        
            if($connectQuery){
                header("location: home.php");
            } else {
                echo "Error editing books <a href='home.php'>[Home]</a> ".mysqli_error($conn);
            } 
        }
    }

    if(isset($_GET['delete'])){
        $deletinBang = $_GET['delete'];
        list($user_id, $book_id) = explode('_', $deletinBang); // buset main ledak2 aja
        // note: 
        /* 
            explode = ngeremove _ dari link yang delete=userid_id terus
            list ngemasukin user_id dan id ke user_id dan book_id 
        */

        $query = "DELETE FROM books WHERE id = $book_id AND user_id = $user_id";
        $connectQuery = mysqli_query($conn, $query);

        if($connectQuery){
            header("location: home.php");
        } else {
            echo "Error deleting the book <a href='home.php'>[Home]</a>";
        }
    }
?>