<?php
/**
 * Created by PhpStorm.
 * User: CHANDIM
 * Date: 11/29/2017
 * Time: 18:15
 */

if (isset($_POST['title'])) {
    $new_book = getData();
    storeNewBook($new_book);
}

//  store the data from user input into a book class
function getData()
{
    require_once('book.php');
    $new_book = new book();
    return $new_book;
}

//  format the new book information
function format($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//  store new book into DB
function storeNewBook($new_book)
{
    $title = format($new_book->getTitle());
    $author = format($new_book->getAuthor());
    $rate = format($new_book->getRate());
    $comment = format($new_book->getComment());
    $status = format($new_book->getStatus());

    //  build connection
    $connection = new MySQLi("127.0.0.1", "root", "1234", "books");

    //  check if connected
    if (mysqli_connect_error()) {
        die("No connection to DB possible!<br />Error: " . mysqli_connect_error());
    }

    //  insert new book
    $insertSQL = "INSERT INTO book (title, author, rate, comment, status) VALUES ('$title','$author','$rate','$comment','$status')";

    if ($connection->query($insertSQL) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insertSQL . "<br>" . $connection->error;
    }

    $connection->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/addBook.css">
    <link rel="stylesheet" type="text/css" href="style/rateStar.css">
    <title>Visitor history</title>
</head>
<body>
<div class="table-area">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <caption>Add a new book</caption>
            <!--        title-->
            <tr>
                <td>title:</td>
                <td><input type="text" name="title" required></td>
            </tr>

            <!--        author-->
            <tr>
                <td>author:</td>
                <td><input type="text" name="author" pattern="[a-zA-Z]+ [a-zA-Z]+"
                           title="e.g. Taylor Swift (no digits and special characters allowed)" required></td>
            </tr>

            <!--        rate stars-->
            <tr>
                <td>rate:</td>
                <td>
                    <fieldset class="rate">
                        <input type="radio" id="star6" name="rate" value="6" checked/><label for="star6"></label>
                        <input type="radio" id="star5" name="rate" value="5"/><label for="star5"></label>
                        <input type="radio" id="star4" name="rate" value="4"/><label for="star4"></label>
                        <input type="radio" id="star3" name="rate" value="3"/><label for="star3"></label>
                        <input type="radio" id="star2" name="rate" value="2"/><label for="star2"></label>
                        <input type="radio" id="star1" name="rate" value="1"/><label for="star1"></label>
                    </fieldset>
                </td>
            </tr>

            <!--        comment-->
            <tr>
                <td>comment:</td>
                <td><input type="text" name="comment"></td>
            </tr>

            <!--        status-->
            <tr>
                <td>status:</td>
                <td>
                    <fieldset class="status">
                        <input type="radio" id="buy" name="status" value="buy" checked><label for="buy">buy</label>
                        <input type="radio" id="read" name="status" value="read"><label for="read">read</label>
                        <input type="radio" id="finished" name="status" value="finished"><label
                                for="finished">finished</label>
                    </fieldset>
                </td>
            </tr>

            <!--        submit & cancel-->
            <tr>
                <td colspan="2">
                    <input type="submit" value="Save" class="submit">
                    <input type="reset" value="Cancel" class="reset">
                </td>
            </tr>


        </table>
    </form>
    <!--        display books overview-->
    <button onclick="location.href='overview.php'" value="">All books' overview</button>
</div>
</body>
</html>