<?php

require_once "../classes/book.php";
$bookObj = new Book();

$book = ["title"=>"", "author"=>"", "genre"=>"", "publication"=>""];
$errors = ["title"=>"", "author"=>"", "genre"=>"", "publication"=>""];

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["publication"] = trim(htmlspecialchars($_POST["publication"]));

    if (empty($book["title"]))
    {
        $errors["title"] = "TITLE IS REQUIRED!!!";
    }

    if (empty($book["author"]))
    {
        $errors["author"] = "AUTHOR IS REQUIRED!!!";
    }

    if (empty($book["genre"]))
    {
        $errors["genre"] = "GENRE IS REQUIRED!!!";
    }

    if (empty($book["publication"]))
    {
        $errors["publication"] = "PUBLICATION YEAR IS REQUIRED!!!";
    }
    else if (!is_numeric($book["publication"]) || $book["publication"] > date("Y"))
    {
        $errors["publication"] = "PUBLICATION YEAR MUST BE A NUMBER AND CANNOT BE IN THE FUTURE!!!";
    }

    if (empty(array_filter($errors)))
    {
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication = $book["publication"];

        if ($bookObj->addBook())
        {
            header("Location: viewbooks.php");
            //echo "SUCCESS!!!";
        }
        else
        {
            echo "FAILED!!!";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label {
            display: block;
        }
        span, .error {
            color: red;
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <form action="" method="POST">
        <label for="">Field with <span>*</span> is required</label>
        
        <label for="title">Book Title <span>*</span></label>
        <input type="text" name="title" value="<?= $book["title"] ?>">
        <p class="error"><?= $errors["title"] ?></p>

        <label for="author">Book Author <span>*</span></label>
        <input type="text" name="author" value="<?= $book["author"] ?>">
        <p class="error"><?= $errors["author"] ?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--SELECT GENRE--</option>
            <option value="History" <?= ($book["genre"] == "History")? "selected": ""?> >History</option>
            <option value="Science" <?= ($book["genre"] == "Science")? "selected": ""?> >Science</option>
            <option value="Fiction" <?= ($book["genre"] == "Fiction")? "selected": ""?> >Fiction</option>
        </select>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="publication">Publication Year <span>*</span></label>
        <input type="text" name="publication" value="<?= $book["publication"] ?>">
        <p class="error"><?= $errors["publication"] ?></p>

        <br>

        <input type="submit">
    </form>
</body>
</html>