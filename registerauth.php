<?php

session_start();


require 'functions.php';

if (isset($_POST['email'], $_POST['username'], $_POST['password'])) {


    $username = trim(htmlspecialchars($_POST['username']));
    $fname = trim(htmlspecialchars($_POST['fname']));
    $lname = trim(htmlspecialchars($_POST['lname']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));



    $passwordhash = password_hash($password, PASSWORD_BCRYPT);

    $user = [
        'username' => $username,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'password' => $passwordhash,
    ];

    
    $emailexist = checkIfEmailExist($pdo, $email);

    foreach ($emailexist as $ex) {
        $thisEmail = $ex['email'];
    }

    if ($thisEmail == $email) {

        if(!empty($_POST['email'])){
        $_SESSION['email_exist'] = true;
        }
        header('Location: register.php');
        exit;
    }




    $usernameexist = checkIfUsernameExist($pdo, $username);

    foreach ($usernameexist as $exist) {
        $thisUsername = $exist['username'];
    }

    if ($thisUsername == $username) {

        if(!empty($_POST['username'])){
        $_SESSION['username_exist'] = true;
        }
        header('Location: register.php');
        exit;
    }



    addToDatabase($pdo, 'users', $user);

    $id = getIdByEmail($pdo, $email);

    foreach($id as $i){
        $id = $i->id;
    }
    
    session_regenerate_id();
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['userid'] = $id;
    $_SESSION['email'] = $user['email'];
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];

    header('Location: profile.php');
}


