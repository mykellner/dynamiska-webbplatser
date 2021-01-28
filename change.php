<?php

session_start();


require 'functions.php';

$pdo = initDatabase();

$currentDateTime = date('Y-m-d H:i:s');

if(isset($_POST['submit-settings'])){
    
    if(!empty($_POST['email'])){
        $email = $_POST['email'];
        $id = $_SESSION['userid'];
        changeEmail($pdo, $email, $id, $currentDateTime);
        $_SESSION['email'] = $email;
    };

    if((!empty($_POST['password']))){
        $password = $_POST['password'];
        $passwordhash = password_hash($password, PASSWORD_BCRYPT);
        $id = $_SESSION['userid'];
        changePassword($pdo, $passwordhash, $id, $currentDateTime);
    };

    if((!empty($_POST['username']))){
        $username = $_POST['username'];
        $id = $_SESSION['userid'];
        changeUsername($pdo, $username, $id, $currentDateTime);
        $_SESSION['username'] = $username;
    };

    header('Location: profile.php');
    
}


function changeEmail($pdo, $email, $userid, $currentDateTime){

    $exist = checkIfEmailExist($pdo, $email);

    foreach ($exist as $ex) {
        $thisEmail = $ex['email'];
    }

    if ($thisEmail == $email) {

        if(!empty($_POST['email'])){
        $_SESSION['email_exist'] = true;
        }
        header('Location: changesettings.php');
        exit;
    }

    $sql = 'UPDATE users SET email = :email, updated_at = :updated_at WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $email,
        'updated_at' => $currentDateTime,
        'id' => $userid,
    ]);

}

function changePassword($pdo, $passwordhash, $userid, $currentDateTime){
    $pdo = initDatabase();
    $sql = 'UPDATE users SET password = :password, updated_at = :updated_at WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'password' => $passwordhash,
        'updated_at' => $currentDateTime,
        'id' => $userid,
    ]);

}


function changeUsername($pdo, $username, $userid, $currentDateTime){

    $usernameexist = checkIfUsernameExist($pdo, $username);

    foreach ($usernameexist as $exist) {
        $thisUsername = $exist['username'];
    }

    if ($thisUsername == $username) {

        if(!empty($_POST['username'])){
        $_SESSION['username_exist'] = true;
        }
        header('Location: changesettings.php');
        exit;
    }

    $sql = 'UPDATE users SET username = :username, updated_at = :updated_at WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'username' => $username,
        'updated_at' => $currentDateTime,
        'id' => $userid,
    ]);

    $_SESSION['username'] = $username;

}