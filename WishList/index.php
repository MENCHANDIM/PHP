<?php
/**
 * Created by PhpStorm.
 * User: CHANDIM
 * Date: 11/12/2017
 * Time: 10:13
 */

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wish list</title>
</head>
<body>

<div>

    <?php
    $msg = '';
    $first_form = '';
    $second_form = '';
    $first_form_content = '';
    $second_form_content = '';
    $title = '';
    $buttons = '';

    main();

    function main()
    {
        //  check if user has filled any input, if not
        if (!(checkInput('firstWish') && checkInput('secondWish') && checkInput('thirdWish') && checkInput('fullName'))) {
            //  render the first page
            prepareFirstPage();
        }

        //  check whether the first form is filled, if yes
        if (checkInput('firstWish') || checkInput('secondWish') || checkInput('thirdWish')) {
            //  check whether the first form is valid (no numbers), if yes
            if (wishValid('firstWish') && wishValid('secondWish') && wishValid('thirdWish')) {
                //  render the second page
                prepareSecondPage();
            }
        }

        //  check whether the second form is filled, if yes
        if (checkInput('fullName') && checkInput('address') && checkInput('phone')) {
            //  render the third page
            prepareThirdPage();
        }
    }

    //  check whether an input exists and whether it is empty, if yes
    //  store it in session
    function checkInput($input_name)
    {
        //  if filled, store it to session
        if (isset($_POST[$input_name]) && !empty($_POST[$input_name])) {
            $_SESSION[$input_name] = $_POST[$input_name];
            return true;
        } else {
            return false;
        }
    }

    //  validate wish and store it to session
    function wishValid($wish)
    {
        global $msg;
        //  check whether is filled, if yes
        if (checkInput($wish)) {
            //  check whether it's valid, if yes
            //  no addition message will be shown
            if (!preg_match("/\d/", $_POST[$wish])) {
                $msg = '';
                return true;
                //  if not valid
                //  delete the session and show error message
            } else {
                unset($_SESSION[$wish]);
                $msg .= $wish . ' is invalid : cannot contain numbers.<br/>';
                return false;
            }
        }
        //  if empty, return true
        return true;
    }


    //  show first form content
    //  empty wish allowed
    function renderFirstFormContent()
    {
        global $first_form_content;

        $temp = "<ol>";

        if (isset($_SESSION['firstWish'])) {
            $temp .= "<li>Wish " . $_SESSION['firstWish'] . "</li>";
        }
        if (isset($_SESSION['secondWish'])) {
            $temp .= "<li>Wish " . $_SESSION['secondWish'] . "</li>";
        }
        if (isset($_SESSION['thirdWish'])) {
            $temp .= "<li>Wish " . $_SESSION['thirdWish'] . "</li>";
        }
        $temp .= "</ol>";

        $first_form_content = $temp;

    }

    //  render the first page
    function prepareFirstPage()
    {
        global $title;
        global $first_form;
        global $buttons;

        //  show title
        $title = "My Wishlist";

        //  show first form
        $first_form = "<ol>
                            <li><label>Wish <input type=\"text\" name=\"firstWish\"></label></li>
                            <li><label>Wish <input type=\"text\" name=\"secondWish\"></label></li>
                            <li><label>Wish <input type=\"text\" name=\"thirdWish\"></label></li>
                        <ol/>";

        //  show two buttons
        $buttons = "<input type=\"reset\" value=\"Cancel\"><input type=\"submit\" value=\"OK\">";
    }

    //  render the second page
    function prepareSecondPage()
    {
        global $title;
        global $first_form;
        global $second_form;

        //  hide first form
        $first_form = '';

        //  show title
        $title = "Delivery information";

        //  show first form content
        renderFirstFormContent();

        //  show second form
        $second_form = "<table>
                            <tr><td>First and second name: </td>
                                <td><input type=\"text\" name=\"fullName\" pattern=\"\w+ \w+\" title=\"telephone must contain numbers only. e.g John Watson\" required></td>
                            </tr>
                                <tr><td colspan='2' style='color: darkgray'>(telephone must contain numbers only. e.g John Watson)</td></tr>
                            <tr><td>ZIP and city: </td>
                                <td><input type=\"text\" name=\"address\" pattern=\"\d{5} \w+\" title=\"5-digit ZIP and city\" required></td>
                            </tr>
                                <tr><td colspan='2' style='color: darkgray'>(5-digit ZIP and city. e.g 23562 Luebeck)</td></tr>
                            <tr><td>Telephone: </td>
                                <td><input type=\"text\" name=\"phone\" pattern=\"\d{10,13}\" title=\"10 to 13 digits number\" required></td>
                            </tr>
                                <tr><td colspan='2' style='color: darkgray'>(10 to 13 digits number. e.g 1234567890)</td></tr>
                        </table>";
    }

    //  render the third page
    function prepareThirdPage()
    {
        global $title;
        global $first_form;
        global $second_form;
        global $second_form_content;
        global $buttons;

        //  hide first form
        $first_form = '';

        //  hide second form
        $second_form = '';

        //  hide buttons
        $buttons = '';

        //  show title
        $title = "Wishes overview";

        //  show first form content
        renderFirstFormContent();

        //  show second form content
        $second_form_content = "<table><tr><td>First and second name: </td><td>" . $_SESSION['fullName'] . "</td></tr>
                                <tr><td>ZIP and city: </td><td>" . $_SESSION['address'] . "</td></tr>
                                <tr><td>Telephone: </td><td>" . $_SESSION['phone'] . "</td></tr></table>";

        //  clear all sessions
        $_SESSION = array();
    }

    ?>
</div>

<p><?php echo $title ?></p>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <?php echo $first_form ?>
    <?php echo $first_form_content ?>
    <p style="color: red"><?php echo $msg; ?></p>
    <?php echo $second_form ?>
    <?php echo $second_form_content ?>
    <?php echo $buttons ?>
</form>

</body>
</html>