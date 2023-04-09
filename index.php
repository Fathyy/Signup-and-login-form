<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php
    if (isset($_SESSION['user_id'])): ?>
        <p>You are now logged in!</p>
        <a href="logout.php">Log out</a>

        <?php else: ?>
            <p>Login <a href="login.php">here</a>
        </p>
            <p>Sign up<a href="register.php">here</a></p>

    <?php endif ?>

</body>
</html>