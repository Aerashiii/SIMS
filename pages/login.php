<?php


$page = "login";
include '../includes/header.php';

// Display error message if set in session
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Clear the error after displaying it
}
?>

<div class="login-form-main-container">
    <div class="form-container">
        <form action="../config/process-login.php" method="POST" id="login-form"> <!-- Added method="POST" -->
            <h2>General's Space Rent</h2>
            <p>A Web-based Sales and Inventory Management System</p>
            <h4>Hey, Hello! <img src="../assets/images/icons/wave.png" alt=""></h4>
            <div class="login-form-input-contaner">
                <label for="entry-type">Entry Type:</label> <!-- Updated for attribute -->
                <select id="entry-type" name="entry-type"> <!-- Fixed name attribute -->
                    <option value="admin">Admin</option>
                </select>
                <label for="username">Username:</label> <!-- Updated for attribute -->
                <input type="text" id="username" name="username" required> <!-- Added required -->
                <label for="password">Password:</label> <!-- Updated for attribute -->
                <input type="password" id="password" name="password" required> <!-- Added required -->
                
                <input type="submit" name="submit" id="login-submit-button" value="Login">
            </div>
        </form>
    </div>
</div>
