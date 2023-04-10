<?php
session_start();
$isInvalid = false;

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
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        }
    }
    $isInvalid = true;
}


function sanitize_data($data)
{
    $data = strip_tags($data);
    $data = trim($data);
    return $data;
}
?>
<?php require_once __DIR__ . '/inc/header.php';?>
<?php
if ($isInvalid): ?>
    <em>Invalid Login</em>
<?php endif ?>

<form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
<div>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email"
        value="<?php htmlspecialchars($_POST['email'] ?? "")?>">
    </div>

    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit">Login</button>

    <footer>Don't have an account? <a href="register.php">Signup here</a></footer>
</form>

<?php require_once __DIR__ . '/inc/footer.php';?>