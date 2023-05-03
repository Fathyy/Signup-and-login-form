<?php
session_start();
$isInvalid = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/config/database.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the DB
    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC); //fetching the email as an associative array
    if ($user) {
        // if email exists, verify the input password against the hashed one in the DB
        if (password_verify($_POST['password'], $user['password'])) {
            session_regenerate_id(); // regenerate session if a user logs back in again
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        }
    }
    $isInvalid = true;
}

?>
<?php require_once __DIR__ . '/inc/header.php';?>
<?php
// less details about error in order to give attackers less clues
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
    <p><a href="forgot_password.php">Forgot Password?</a></p>
</form>

<?php require_once __DIR__ . '/inc/footer.php';?>