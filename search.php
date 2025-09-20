<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search books</title>
</head>
<body>
    <h1>Book-O-Rama Catalog Search</h1>

    <?php
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

        // ONLY RUN SEARCH AFTER FORM SUBMISSION
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchtype = $_POST['searchtype'] ?? '';
            $searchterm = trim($_POST['search'] ?? '');

            // VALIDATE 
            $allowed = ['isbn', 'author', 'title'];  
            if (!in_array($searchtype, $allowed)) {
                die("Invalid search type");
            }

            // QUERY EXECUTION
            $sql = "SELECT isbn, author, title FROM books WHERE $searchtype LIKE ?";
            $stmt = $conn->prepare($sql);

            $like = "%". $searchterm . "%"; // ALLOWS PARTIAL MATCHES
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h2>Book-O-Rama Search Results</h2>";

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
        }

        $conn->close();
    ?>

    <form action="" method="post">
        Choose Search Type: <br>
        <select name="searchtype">
            <option value="isbn">ISBN</option>
            <option value="author">Author</option>
            <option value="title">Title</option>
        </select>
        <br>
        Enter Search Item: <br>
        <input type="text" name="search">
        <br>
        <button type="submit">Search</button>
    </form>

</body>
</html>
