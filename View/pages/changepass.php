<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
} else {
    include('../../config/database.php');

    $id = $_SESSION['id'];
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    $username = $_SESSION['username'];
}
?>
<form action='../../Controller/resetpassword.php' method='POST'>
    <h3>CHANGE PASSWORD</h3>
    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">
    <label for='currentPass'>Current Password</label>
    <input id='currentPass' type='password' name='currentPass'>
    <label for='newPass'>New Password</label>
    <input id='newPass' type='password' name='newPass'>

    <label for='confirmPass'>Confirm Password</label>
    <input id='confirmPass' type='password' name='confirmPass'>

    <button type='submit' name='reset-password'>Confirm</button>


</form>"