<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $inputs = []; //haven't used this yet
    $errors = [];

    if (empty($username)) {
        $errors['username'] = "username is required";
    }

    // validate the email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($email) {
        $validatedEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    // $inputs['email'] = $validatedEmail;
    if (!$validatedEmail) {
        $errors['email'] = 'Wrong email format';
    }

    // check if the password contains 8 characters and has letters and numbers.
    if (! preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$_POST["password"])) {
        $errors['password'] = "Password must contain numbers and letters and must be at least 8 characters long!";
    }

    // check if both passwords match
    if ($_POST['password'] !== $_POST['password2']) {
        $errors['password2'] = "Passwords should match";
    }

    // hash the password to be stored in the DB
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);


    // if there is no errors in the errors array
    if (count($errors) === 0) {
        // insert data into db
        require __DIR__ . '/config/database.php';
        $stmt = $dbh->prepare("INSERT INTO users (username, email, password) 
        VALUES(:username, :email, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        header("Location: signup-successful.html");
        exit;
    }
    // store errors in a session to be accessed in register.php
    else {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }
      
}

?>