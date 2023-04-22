<?php
session_start();
require_once __DIR__. '/inc/header.php';
?>
<form action="action.php" method="post">
    <?php
    // if there are errors in the session array, display them 
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        // unset to prevent showing of errors after the page is refreshed
        unset($_SESSION['errors']);
    }
    ?>
    
    
    <h1>Sign Up</h1>
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <small style ="color: red;"><?= $errors['username'] ?? '' ?></small>
    </div>

    <div>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <small style ="color: red;"><?= $errors['email'] ?? '' ?></small>
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <small style ="color: red;"><?= $errors['password'] ?? ''?></small>
    </div>

    <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2">
        <small style ="color: red;"><?= $errors['password2'] ?? '' ?></small>
    </div>

    <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="checked" /> I
            agree
            with the
            <a href="#" title="term of services">term of services</a>
        </label>
    </div>

    <button type="submit" name="submit">Register</button>

    <footer>Already a member? <a href="login.php">Login here</a></footer>

</form>

<?php require_once __DIR__. '/inc/footer.php';?>
