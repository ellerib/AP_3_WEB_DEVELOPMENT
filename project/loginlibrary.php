<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Library System Login </title>
</head>
<body>

    <?php
        


    ?>
    
    <form action="" method="post">

        Username: <br> <input type="text" name="username" required>
        <br>
        Password: <br> <input type="password" name="password" required>
        <br>

        Role Type <br>
        <select name="roletype"> 
            <option value="student"> Student </option>
            <option value="teacher"> Teacher </option>
            <option value="librarian"> Librarian </option>
            <option value="staff"> Staff </option>
        </select>

        <button type="submit"> Login </button>

    </form>


</body>
</html>