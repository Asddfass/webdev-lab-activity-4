<?php
require_once "../classes/book.php";
$bookObj = new Book();

$search = "";
$genre = "";

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])): "";
    $genre = isset($_GET["genre"])? htmlspecialchars($_GET["genre"]): "";  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books</title>
</head>
<body>
    <button><a href="addbook.php">Go Back To Add Book</a></button>

    <form action="" method="GET">
    <br>
    <label for="">Search</label>
    <input type="text" name="search" value="<?= $search ?>"><br>
    <label for="">Filter by genre</label>
    <select name="genre" id="genre">
            <option value="">--ALL--</option>
            <option value="History" <?= ($genre == "History")? "selected": ""?> >History</option>
            <option value="Science" <?= ($genre == "Science")? "selected": ""?> >Science</option>
            <option value="Fiction" <?= ($genre == "Fiction")? "selected": ""?> >Fiction</option>
    </select>
    <input type="submit" value="Search">
    </form>
    
    <h1>List of Books</h1>

    <table border="1" width="100%">
        <tr>
            <td>No.</td>
            <td>Title</td>
            <td>Book Author</td>
            <td>Genre</td>
            <td>Publication Year</td>
        </tr>
        <?php 
            $no = 1;
            foreach ($bookObj->viewbooks($search, $genre) as $books)
            {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $books["title"] ?></td>
            <td><?= $books["author"] ?></td>
            <td><?= $books["genre"] ?></td>
            <td><?= $books["publication"] ?></td>
        </tr>

        <?php
            }
        ?>
    </table>
</body>
</html>