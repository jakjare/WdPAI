<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/devices.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
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
    <main class="devices">
        <div id="filter">
            <i class="fas fa-filter"></i>
            <form>
                <div>
                    Email
                    <input name="email" type="text">
                </div>
                <div>
                    Permission
                    <input name="permission" type="text">
                </div>
                <div class="break">
                    <button type="submit">Apply</button>
                    <button type="reset">Clear</button>
                </div>
            </form>
        </div>
        <div id="devices-list">
            <table class="devices-table">
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
                <tr id="#<?php echo $user->getIdDatabase(); ?>">
                    <td><?php echo $user->getName(); ?></td>
                    <td><?php echo $user->getSurname(); ?></td>
                    <td><?php echo $user->getEmail(); ?></td>
                    <td><?php echo $user->getRole(); ?></td>
                    <td><?php echo $user->isEnabled() ? 'Active' : 'Inactive'; ?></td>
                    <td><?php echo substr($user->getLastLogin(), 0, -7); ?></td>
                    <td><i class="fas fa-user-edit"></i><i class="fas fa-user-lock"></i><i class="fas fa-trash"></i></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</div>
</body>