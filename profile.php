<?php

session_start();
unset($_SESSION["email_exist"]);
unset($_SESSION["username_exist"]);

require 'functions.php';

$userid = $_SESSION['userid'];
$messages = getMessages($pdo, $userid);
$profilePicture = getProfilePicture($pdo, $userid);

if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}


if($_FILES){
    $uploaddir = dirname(__FILE__) . '/images/';
    $filename = $_SESSION['userid'] . $_FILES['myFile']['name'];
    $uploadfile = $uploaddir .'/' . $_SESSION['userid'] . $_FILES['myFile']['name'];
    

    echo '<pre>';
    if (move_uploaded_file($_FILES['myFile']['tmp_name'], $uploadfile)) {
        addImageToDatabase($pdo, $filename, $userid);
        header('Location: profile.php');
    } else {

        echo 'Possible file upload attack!';
        header('Location: profile.php');
        
        
    }
}


include 'header.php';

?>

<body>
    <main class="container profile-main">
        <div class="container main-container">

            <div class="row">
                <div class="col-2">
                    <div class="imageprofile">
                    <img class="profilepicture" src="images/<?= $profilePicture; ?>" />
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="filebutton">
                            <input type="file" id="file" name="myFile" value="Choose file">
                        </div>

                        <input type="submit" name="submit" value="Upload" class="btn-primary" />
                    </form>
                </div>
                    
                

                <div class="col-4">
                    <h2 class="profile-name"><?php echo $_SESSION['username'] ?></h2>

                    <p class="userinfo"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] . " / " . $_SESSION['email'] ?> </p>

                    <a href="changesettings.php">Change settings</a>
                </div>

            <div class="col-6 message-col">

            <h2 class="post-title">Posts</h2>

                <?php foreach ($messages as $message) : ?>

                    <form method="post">
                    
                   <p class="p-message"> <?php echo $message['sender'] . " skrev: " . $message['message']  ?>
                        <input type="hidden" name="messageid" value="<?php echo $message['id'] ?>">
                        <button type="submit" name="delete-message" class="btn"><i class="fas fa-trash-alt"></i></button> </p>
                    </form>

                <?php endforeach; ?>

              
                <form method="POST">
                        <input type="textarea" class="form-control" name="message">
                        <button type="submit" class="btn-primary" name="submit-post">Post</button>
                    </form>

                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php' ?>

</body>


