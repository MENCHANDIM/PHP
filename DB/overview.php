<?php
/**
 * Created by PhpStorm.
 * User: CHANDIM
 * Date: 12/3/2017
 * Time: 18:16
 */

$all_book_sorted = "";
$resultSet = "";
$aa ="";

//  read all books stored in DB
readDB();

function readDB(){
    global $all_book_sorted;
    global $resultSet;

    //  build connection
    $connection = new MySQLi("127.0.0.1", "root", "1234", "books");

    //  Check if connected
    if (mysqli_connect_error()) {
        die("No connection to DB possible!<br />Error: ".mysqli_connect_error());
    }

    $sql = "SELECT title, author, rate, comment, status FROM book";

    if(isset($_GET['radio']) && !empty($_GET['radio'])){
        $sql .= " ORDER BY ".$_GET['radio'];
    }

    $resultSet = $connection->query($sql);

    // Read out result set line by line
    while (list($title, $author, $rate, $comment, $status) = $resultSet->fetch_row()) {
        $all_book_sorted .= "<tr><td>$title</td><td>$author</td><td>$rate</td><td>$comment</td><td>$status</td></tr>";
    }

    $connection->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book overview</title>
</head>
<body>

<form action="" method="get">
<table>
    <tr>
        <td colspan="5">
            <fieldset>
                <input type="radio" name="radio" id="title" value="title" /><label for="title">title</label>
                <input type="radio" name="radio" id="status" value="status" /><label for="status">status</label>
                <input type="radio" name="radio" id="rate" value="rate" /><label for="rate">rate</label>
                <input type="submit" value="Sort" />
            </fieldset>
        </td>
    </tr>
    <tr>
        <td>title</td>
        <td>author</td>
        <td>rate</td>
        <td>comment</td>
        <td>status</td>
    </tr>
    <?php echo $all_book_sorted ?>
    <th>
            <input type="button" onclick="location.href='index.php';" value="add a new book">
    </th>
</table>
</form>
