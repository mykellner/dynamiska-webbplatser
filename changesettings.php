<?php

include 'header.php';

session_start();

?>

<main class="container">

    <div class="container container-main">

        <div class="row settings-container">

            <div class="col-6">

                <form action="change.php" method="POST">

                    <h2>Fyll i dem uppgifterna du vill ändra</h2>

                    <?php if(isset($_SESSION['email_exist']) && $_SESSION['email_exist']) : ?>
                    <label> Emailen är redan registrerad i vår databas. </label>
                    <?php endif; ?>
                    <label for="email">Byt email:</label>
                    <input type="text" class="form-control" name="email">

                    <label for="email">Byt Lösenord:</label>
                    <input type="text" class="form-control" name="password">

                    <?php if(isset($_SESSION['username_exist']) && $_SESSION['username_exist']) : ?>
                    <label> Användarnamnet är upptaget, vänligen välj ett annat. </label>
                    <?php endif; ?>
                    <label for="email">Byt användarnamn:</label>
                    <input type="text" class="form-control" name="username">

                    <button type="submit" class="btn-primary" name="submit-settings">Spara</button>

                </form>
            </div>

        </div>

    </div>

</main>