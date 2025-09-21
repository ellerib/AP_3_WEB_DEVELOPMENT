<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Book-O-Rama Book Deletion </title>
</head>
<body>

    <h1> Book-O-Rama Book Deletion </h1>

    <form action="" method="post">
        ISBN: <br> <input type="text" name="isbndelete">
        <br>
        Author: <br> <input type="text" name="authordelete">
        <br>

        <button type="submit"> Submit </button>
    </form>

    <?php

        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "book_o_rama";

        $conn = new mysqli($host,$username,$password, $db);

        if($conn->connect_error){   
            die("Error connecrtion".$conn->connect_error);
        }
        
        if($_SERVER["REQUEST_METHOD"]=='POST'){
            $deleteisbn = $_POST['isbndelete'] ?? '';
            $deleteauthor = $_POST['authordelete'] ?? '';


             if(empty($deleteisbn) || empty($deleteauthor)){
                echo "<script> alert('ISBN and Author required') </script>";
            }else{
            // VALIDATING IF AUTHOR EXISTS ON THE DB
                $checkauthor = $conn->prepare("SELECT author FROM books 
                WHERE author = ?");

                $checkauthor->bind_param("s", $deleteauthor);
                $checkauthor->execute();
                $result = $checkauthor->get_result();
            if($result->num_rows>0){
           
            $deletebook = $conn->prepare("DELETE FROM books WHERE isbn = ? AND author = ?");
            $deletebook->bind_param("ss", $deleteisbn, $deleteauthor);

            if($deletebook->execute()){
                echo "<script> window.alert('Book successfully deleted') </script>";
            }else{
                echo "<script> window.alert('Book unsuccessfully deleted')</script>";
            }
            $deletebook->close();            

        }else{
            echo "No book found with the name: '$deleteauthor'";
        }

            $checkauthor->close();
                
        } 
        $conn->close();

        }

    
    ?>
    

</body>
</html>