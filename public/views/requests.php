<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/objects.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/deviceEditor.js" defer></script>
    <title>AdminGate - dashboard</title>
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
    <main class="requests, objects">
        <div class="option-bar">
            <a href="newRequest"><button id="newRequestButton">New</button></a>
            <button id="deleteCheckedButton">Delete</button>
            <a href="archiveRequests"><button id="archiveButton">Archive</button></a>
        </div>
        <div id="object-list">
            <table class="objects-table">
                <tr>
                    <th style="width: 10px"><input type="checkbox"></th>
                    <th>Sender</th>
                    <th>Topic</th>
                    <th>Time</th>
                    <th></th>
                </tr>
                <?php foreach ($requests as $request): ?>
                    <tr class="<?php echo $request->isRead() ? '' : 'bold'?>" id="<?php echo $request->getId(); ?>">
                        <td><input type="checkbox"></td>
                        <td><?php echo $request->getSender()->getName().' '.$request->getSender()->getSurname(); ?></td>
                        <td><?php echo $request->getTopic(); ?></td>
                        <td><?php echo $request->getTime(); ?></td>
                        <td><i class="fas fa-archive"></i></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</div>
</body>