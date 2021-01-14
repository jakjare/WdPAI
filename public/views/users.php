<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/objects.css">
    <link rel="stylesheet" type="text/css" href="public/css/settings.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/dataValidation.js" defer></script>
    <script type="text/javascript" src="./public/js/userEditor.js" defer></script>
    <title>AdminGate - users</title>
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
    <main class="objects">
        <div class="option-bar">
            <input name="search">
            <button><i class="fas fa-search"></i></button>
            <button id="userAddButton">Add user</button>
        </div>
        <div id="object-list">
            <table class="objects-table">
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Permissions</th>
                    <th>Status</th>
                    <th>Last login</th>
                    <th style="text-align: right;"></th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr id="<?php echo $user->getIdDatabase(); ?>">
                    <td><?php echo $user->getName(); ?></td>
                    <td><?php echo $user->getSurname(); ?></td>
                    <td id="email"><?php echo $user->getEmail(); ?></td>
                    <td><?php echo $user->getRole(); ?></td>
                    <td id="status"><?php echo $user->isEnabled() ? 'Active' : 'Inactive'; ?></td>
                    <td><?php echo substr($user->getLastLogin(), 0, -7); ?></td>
                    <td><i class="fas fa-user-edit"></i><i class="fas fa-user-lock"></i><i class="fas fa-trash"></i></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
    <div class="overlay">
        <div class="popup">
            <h1>New user</h1>
            <form class="settings-form" action="addUser" method="post">
                <input name="old-email" type="text" readonly>
                <div>
                    <div>
                        Email address
                        <input name="email" type="text">
                    </div>
                    <div>
                        Password
                        <input name="new-password" type="password">
                    </div>
                    <div>
                        Confirm password
                        <input name="confirm-password" type="password">
                    </div>
                    <div>
                        Name
                        <input name="name" type="text">
                    </div>
                    <div>
                        Surname
                        <input name="surname" type="text">
                    </div>
                    <div>
                        Phone
                        <input name="phone" type="text">
                    </div>
                    <div>
                        Role
                        <select name="role">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                            <?php //TODO ?>
                        </select>
                    </div>
                </div>
                <button type="submit">confirm</button>
            </form>
            <button id="exitPopupButton">exit</button>
        </div>
    </div>
</div>
</body>