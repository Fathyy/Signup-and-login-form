<?php
session_start();
require_once __DIR__ . '/inc/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/config/database.php';
    $email = sanitize_data($_POST['email']);
    $password = sanitize_data($_POST['password']);

    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        }
    }
}

function sanitize_data($data)
{
    $data = strip_tags($data);
    $data = trim($data);
    return $data;
}
?>
<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
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
    <button type="submit">Login</button>

    <footer>Don't have an account? <a href="register.php">Signup here</a></footer>
</form>

<?php require_once __DIR__ . '/inc/footer.php';?>