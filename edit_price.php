<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Book-O-Rama Price Update </title>
</head>
<body>

    <?php

        $host = "localhost";
        $username = "root";
        $password = "";
        $db = "book_o_rama";

        $conn = new mysqli($host,$username,$password,$db);

        if($conn->connect_error){
            die("Connection error".$conn->connect_error);
        }

        $isbn = $_POST['isbn'] ?? '';
        $editprice = $_POST['editprice'] ?? '';

        if(empty($isbn) || empty($editprice)){
            echo "<script> alert('ISBN and Price required ') </script>";
        } elseif(!is_numeric($editprice)){
            echo "<script> alert('Price must be numeric') </script>";
        }else{
            $editbookprice = $conn->prepare("UPDATE books SET price = ? WHERE isbn=?");
            $editbookprice->bind_param("ds", $editprice, $isbn);
            
            if($editbookprice->execute()){
                echo "<script> window.alert('Price successfully update on ISBN: $isbn') </script>";
                header("edit_price.php");
            }else{
                echo "<script> window.alert('Price unsuccessfully updated on ISBN: $isbn ') </script>";
                header("edit_price.php");
            }

            $editbookprice->close();

        }
        
        $conn->close();

    ?>
    
    <form action="" method="post">
        ISBN: <br> <input type="text" name="isbn">
        <br>
        Enter new book price: <br> <input type="text" name="editprice">
        <br>

        <button type="submit"> Submit </button>

    </form>

</body>
</html>