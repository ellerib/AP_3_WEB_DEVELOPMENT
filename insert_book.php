<?php

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "book_o_rama";    

    $conn = new mysqli($host, $user, $pass, $db);

    // CONNECTION CHECK
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $isbn = trim($_POST['isbn']) ?? '';
        $author = trim($_POST['author']) ?? '';
        $title = trim($_POST['title']) ?? '';
        $price = trim($_POST['price']) ?? '';

        //VALIDATION OF INPUT
        if(empty($isbn)){
            echo "
                <script> alert('ISBN is required'); 
                    window.location.href = 'newbook.html';
                </script>
            ";
            exit;
        }

        if(empty($author)){
            echo "
            <script> alert('Author is required') 
                window.location.href = 'newbook.html';
            </script>";
            exit;
        }

        if(empty($title)){
            echo "<script> 
                alert('Titile is required');
                window.location.href = 'newbook.html';
            </script>";
            exit;
        }

        if(!is_numeric($price)){
            echo "
                <script> 
                    alert('Price must be numeric');
                    window.location.href = 'newbook.html';

                </script>
            ";
            exit;
        }

        $sql = "INSERT INTO books(isbn, author, title, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssd", $isbn, $author, $title, $price);


        if($stmt->execute()){
            echo htmlspecialchars($stmt->affected_rows) . "<script> window.alert('Book added and saved to the database')</script>";
        }else{
            echo "<script> window.alert('Book unsuccessfully added')</script>";
        }

        $stmt->close();
        
    }

    $conn->close();
    
?>