<?php

    $searchtype = $_POST['searchtype'];
    $searchterm = trim($_POST['search']);

    // CONNECT DATABASE

    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "book_o_rama";    

    $conn = new mysqli($host, $user, $pass, $db);

    // CONNECTION CHECK
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // QUERY EXECUTION

    $sql = "SELECT isbn, author, title FROM books WHERE $searchtype LIKE ?";
    $stmt = $conn->prepare($sql);

    $like = "%". $searchterm . "%"; // ALLOWS PARTIAL MATCHES
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2> Book-O-Rama Search Results </h2>";

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='margin-bottom:15px; border-bottom:1px solid #ccc; padding-bottom:10px;'>";
        echo "<p><strong>Title:</strong> " . htmlspecialchars($row['title']) . "</p>";
        echo "<p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>";
        echo "<p><strong>ISBN:</strong> " . htmlspecialchars($row['isbn']) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No results found.</p>";
}

    $stmt->close();
    $conn->close();

?>
