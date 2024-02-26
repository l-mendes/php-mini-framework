<?php

use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// validate the form inputs
$errors = [];

if (! Validator::string($name, 3, 255)) {
    $errors['email'] = 'Please enter your name';
}

if (! Validator::email($email)) {
    $errors['email'] = 'Please enter a valid email address';
}

if (! Validator::string($password, 7, 255)) {
    $errors['password'] = 'Password must be at least 7 characters';
}

if (! empty($errors)) {
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

// check if the account already exists
$user = $db->query('SELECT * FROM users WHERE email = :email', [
    'email' => $email
])->find();

if ($user) {
    header('Location: /');
    exit();
}

$db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)', [
    'name' => $name,
    'email' => $email,
    'password' => $password,
]);

$_SESSION['user'] = [
    'email' => $email
];

header('Location: /');
exit();
