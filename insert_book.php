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

    // $isbn = trim($_POST['isbn']) ?? '';
    // $author = trim($_POST['author']) ?? '';
    // $title = trim($_POST['title']) ?? '';
    // $price = trim($_POST['price']) ?? '';

    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    //VALIDATION OF INPUT
    if(empty($isbn)){
        echo "ISBM is required";
        exit;
    }

    if(empty($author)){
        echo "Author is required";
        exit;
    }

    if(empty($title)){
        echo "Title is required";
        exit;
    }

    if(!is_numeric($price)){
        echo "Price must be number";
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
    $conn->close();

?>