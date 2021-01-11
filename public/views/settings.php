<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/settings.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/dataValidation.js" defer></script>
    <title>AdminGate - settings</title>
</head>
<body>
<div class="base-container">
    <header>
        <?php
        include_once("public/shared/header.php");
        ?>
    </header>
    <nav>
        <?php
        include_once("public/shared/menu.php");
        ?>
    </nav>
    <main class="settings">
        <div>
            <h1>Account settings</h1>
            <h2>Avatar</h2>
            <form class="avatar-form" action="addAvatar" method="post" enctype="multipart/form-data">
                <div class="avatar" style="background: transparent url('<?php echo '../public/uploads/users_avatars/'.$_SESSION['image']; ?>') no-repeat center; background-size: 4em; width: 4em; height: 4em;"></div>
                <input class="input-avatar" type="file" name="avatar"/>
                <input type="file" id="file" name="avatar" />
                <label for="file" />choice image</label>
                <button type="submit">upload</button>
            </form>
            <?php
            if(isset($messages)) {
                foreach ($messages as $message) {
                    echo "<div class=\"messeges\">".$message."</div>";
                }
            }
            ?>
            <h2>Personal details</h2>
            <form class="settings-form" method="post" action="settings">
                <div>
                    <div>
                        Name
                        <input name="name" type="text" placeholder="<?php echo $name ?>">
                    </div>
                    <div>
                        Surname
                        <input name="surname" type="text" placeholder="<?php echo $surname ?>">
                    </div>
                    <div>
                        Email address
                        <input name="email" type="text" placeholder="<?php echo $email ?>">
                    </div>
                    <div>
                        Phone number
                        <input name="phone" type="text" placeholder="<?php echo $phone === '0' ? 'None set' : $phone?>">
                    </div>
                </div>
                <button type="submit">save changes</button>
            </form>
            <h2>Security</h2>
            <form class="settings-form" method="post" action="changePassword">
                <div>
                    <div>
                        Old password
                        <input name="current-password" type="password">
                    </div>
                    <div>
                        New password
                        <input name="new-password" type="password">
                    </div>
                    <div>
                        Confirm new password
                        <input name="confirm-password" type="password">
                    </div>
                </div>
                <button type="submit">update password</button>
            </form>
        </div>
    </main>
</div>
</body>