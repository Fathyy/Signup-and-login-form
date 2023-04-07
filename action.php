<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_data($_POST['username']);
    $email = sanitize_data($_POST['email']);
    $password = sanitize_data($_POST['password']);
    $password2 = sanitize_data($_POST['password2']);

    $inputs = [];
    $errors = [];

    if (empty($username)) {
        $errors['username'] = "username is required";
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($email) {
        $validatedEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    $inputs['email'] = $validatedEmail;
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

    if (count($errors) === 0) {
        header("Location: index.php");
        exit;
    }
    else {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }
      
}

function sanitize_data($data)
{
    $data = strip_tags($data);
    $data = trim($data);
    return $data;
}

?>