<?php

session_start();

require 'functions.php';

$userid = $_GET['id'];

$messages = getMessages($pdo, $userid);


if (!isset($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}

include 'header.php';

?>

<body>

    <main class="container">
        <div class="container main-container">
            <div class="row">
                <div class="col-2">

                    <h2>Users</h2>

                    <ul>
                        <?php if (!isset($_GET['id'])) : ?>
                            <?php foreach ($allUsers as $user) : ?>
                                <?php if ($user->id != $_SESSION['userid']) : ?>
                                    <li> <a href="users.php?id=<?php echo $user->id; ?>"><?= $user->username ?> </a> </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (isset($_GET['id'])) : ?>
                            <a href="users.php">All users</a>
                        <?php endif; ?>
                    </ul>
                </div>




                <?php if (!isset($_GET['id'])) : ?>

                    <div class="col-10">
                        <form action="" method="POST">
                            <input type="text" name="query" />
                            <input type="submit" name="submit-search" class="btn-primary" value="search" />
                        </form>

                        <div class="pictures">

                            <?php if (isset($_POST['submit-search'])) : ?>

                                <?php $results = getSearch($pdo); ?>

                                <?php foreach ($results as $result) : ?>
                                    <?php if($result['id'] != $_SESSION['userid']) : ?>
                                    <div class="imagewrapper"><?php echo $result['fname'] . " " .  $result['lname'] ?> <a href="users.php?id=<?php echo $result['id']; ?>"><img src="images/<?= $result['image']; ?>" alt="" class="imagesfront"></a></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>


                            <?php endif; ?>

                            <?php if (!isset($_POST['submit-search'])) : ?>
                                <?php $results = getSearch($pdo); ?>
                                <?php foreach ($results as $result) : ?>
                                    <?php if($result['id'] != $_SESSION['userid']) : ?>
                                    <div class="imagewrapper"><?php echo $result['fname'] . " " .  $result['lname'] ?><a href="users.php?id=<?php echo $result['id']; ?>"><img src="images/<?= $result['image']; ?>" alt="" class="imagesfront"></a></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endif; ?>


                <?php if (isset($_GET['id'])) : ?>

                    <div class="col-4">

                        <h2 class="profile-name"> <?php foreach ($thisUser as $user) : ?>
                                <?php echo $user['username'] ?>
                            <?php endforeach; ?> </h2>

                        <p class="userinfo"> <?php foreach ($thisUser as $user) : ?>
                                <?php echo $user['fname'] . " " . $user['lname'] ?>
                            <?php endforeach; ?> </p>

                        <div class="imageprofile">
                            <?php foreach ($thisUser as $user) : ?>
                                <?php $profilePicture = getProfilePicture($pdo, $user['id']) ?>
                                <img class="profilepicture" src="images/<?= $profilePicture; ?>" alt="">
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-6 posts message-col">

                        <h2 class="post-title">Posts</h2>

                        <?php foreach ($messages as $message) : ?>

                            <p><?php echo $message['sender'] . " skrev: " . $message['message'] ?> </p>

                        <?php endforeach; ?>


                        <form method="POST">
                            <input type="textarea" class="form-control" name="message">
                            <button type="submit" class="btn-primary" name="submit-message">Send!</button>
                        </form>

                    </div>
                
                <?php endif; ?>
            </div>
        </div>

        
    </main>

    <?php include 'footer.php' ?>

    
</body>
