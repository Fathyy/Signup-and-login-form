<?php
session_start();
// getting the logged in user based in their session ID
if (isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/config/database.php';
    $stmt = $dbh->prepare("SELECT * FROM users
    WHERE id = {$_SESSION['user_id']}");
    $stmt->execute();
    $user = $stmt->fetch();
}
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
    // Display name of logged in user
    if (isset($user)): ?>
        <p>Hello <?php echo htmlspecialchars($user['username'])?></p>
        <a href="logout.php">Log out</a>

        <?php else: ?>
            <p>Login <a href="login.php">here</a>
        </p>
            <p>Sign up<a href="register.php">here</a></p>

    <?php endif ?>

</body>
</html>