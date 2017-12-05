<?php
/**
 * Created by PhpStorm.
 * User: CHANDIM
 * Date: 12/3/2017
 * Time: 23:17
 */

$new_book = getData();
storeNewBook($new_book);

//  store the data from user input into a book class
function getData(){
    require_once('book.php');
    $new_book = new book();
    return $new_book;
}

//  format the new book information
function format($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//  store new book into DB
function storeNewBook($new_book){
    $title = format($new_book->getTitle());
    $author = format($new_book->getAuthor());
    $rate = format($new_book->getRate());
    $comment = format($new_book->getComment());
    $status = format($new_book->getStatus());

    //  build connection
    $connection = new MySQLi("127.0.0.1", "root", "1234", "books");

    //  check if connected
    if (mysqli_connect_error()) {
        die("No connection to DB possible!<br />Error: ".mysqli_connect_error());
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
