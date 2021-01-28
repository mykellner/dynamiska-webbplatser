<?php

require 'config.php';

session_start();

$pdo = initDatabase();
$allUsers = getAllUsers($pdo);
$id = $_GET['id'];
$thisUser = getUserById($pdo, $id);
$currentDateTime = date('Y-m-d H:i:s');


function addToDatabase($pdo, $tableName, $newData) {
    $sql = sprintf(
        'insert into %s (%s) values (%s)',
        $tableName,
        implode(', ', array_keys($newData)),
        ':' . implode(', :', array_keys($newData))
    );

    $statement = $pdo->prepare($sql);
    $statement->execute($newData);
}


function checkIfEmailExist($pdo, $email) {

    $statement = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $statement->execute([
        'email' => $email
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function checkIfUsernameExist($pdo, $username) {

    $statement = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $statement->execute([
        'username' => $username
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


function getAllUsers($pdo) {

    $statement = $pdo->prepare('SELECT fname, lname, username, id FROM users');
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    return $results;
}

function getUserById($pdo, $id) {

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $statement->execute([
        'id' => $id
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


if (isset($_POST['submit-message'])) {


    if (!empty($_POST['message'])) {
        $message = htmlspecialchars(($_POST['message']));
        $userid = $_GET['id'];
        $sender = $_SESSION['username'];

        addMessage($pdo, $userid, $message, $sender);
    }
}


if (isset($_POST['submit-post'])) {

    if (!empty($_POST['message'])) {
        $message = htmlspecialchars($_POST['message']);
        $userid = $_SESSION['userid'];
        $sender = $_SESSION['username'];

        addMessage($pdo, $userid, $message, $sender);
    }
}


function addMessage($pdo, $userid, $message, $sender){

    $sql = 'INSERT INTO messages (user_id, message, sender) VALUES (:user_id, :message, :sender)';

    $statement = $pdo->prepare($sql);

    $statement->execute([
        'user_id' => $userid,
        'message' => $message,
        'sender' => $sender,
    ]);
}


function getMessages($pdo, $userid) {

    $sql = 'SELECT fname, message, sender, users.id, messages.id FROM users
    JOIN messages
    ON users.id = messages.user_id
    WHERE users.id = :id';

    $statement = $pdo->prepare($sql);
    $id = $userid;

    $statement->execute([
        'id' => $id
    ]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}


if (isset($_POST['delete-message'])) {

    if (isset($_POST['messageid'])) {
        $messageid = $_POST['messageid'];

        deleteMessage($pdo, $messageid);
    }
}


function deleteMessage($pdo, $messageid) {

    $sql = 'DELETE FROM messages WHERE id = :id';
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $messageid,
    ]);
}


function getIdByEmail($pdo, $email) {

    $statement = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $statement->execute([
        'email' => $email,
    ]);

    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    return $results;
}


function addImageToDatabase ($pdo, $image, $userid) {

    $sql = 'INSERT INTO images (user_id, image) VALUES (:user_id, :image)';
    $statement = $pdo->prepare($sql);
    $hasImage = getProfilePicture($pdo, $userid);

    if(!empty($hasImage)){
        
        updatePicture($pdo, $userid, $image);
    
    } else {
        
        $statement->execute([
            'user_id' => $userid,
            'image' => $image,
        ]);
    }

}


function updatePicture($pdo, $userid, $image) {

    $sql = 'UPDATE images SET image = :image, updated_at = :updated_at WHERE user_id = :user_id';
    $currentDateTime = date('Y-m-d H:i:s');
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'image' => $image,
        'updated_at' => $currentDateTime,
        'user_id' => $userid,
    ]);

}


function getProfilePicture ($pdo, $userid) {
    
    $sql = 'SELECT image FROM users
    JOIN images
    ON users.id = images.user_id
    WHERE users.id = :id';

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id' => $userid,
    ]);

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    foreach($results as $result) {
        $picture = $result->image;
    }
    return $picture;

}


function getSearch($pdo) {

$sql = 'SELECT * FROM users WHERE username LIKE ? OR fname LIKE ? OR lname LIKE ?';
$statement = $pdo->prepare($sql);
$statement->execute([
    "%" .$_POST['query']. "%",
    "%" .$_POST['query']. "%",
    "%" .$_POST['query']. "%"
]);

$results = $statement->fetchAll(PDO::FETCH_ASSOC);

$imagearray = [];

foreach($results as $result) {
    $image = getProfilePicture($pdo, $result['id']);
    $array = [
        'image' => $image,
        'id' => $result['id'],
        'fname' => $result['fname'],
        'lname' => $result['lname']
    ];
    array_push($imagearray, $array);
}
return $imagearray;

}



