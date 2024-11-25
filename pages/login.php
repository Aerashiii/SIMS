<?php
    $page="login";
    include '../includes/header.php';
?>

<div class="login-form-main-container">
    <div class="form-container">
        <form action="" id="login-form">
            <h2>General's Space Rent</h2>
            <p>A Web-based Sales and Inventory Management System</p>
            <h4>Hey, Hello! <img src="../assets/images/icons/wave.png" alt=""></h4>
            <div class="login-form-input-contaner">
                <label for="">Entry Type:</label>
                <select name="" id="entry-type" name="entry-type">
                    <option value="">Admin</option>
                </select>
                <label for="">Username:</label>
                <input type="text" id="username" name="username">
                <label for="">Password:</label>
                <input type="password" id="password" name="password">
                
                <input type="submit" name="submit" id="login-submit-button" value="Login">
            </div>

        </form>
    </div>

</div>