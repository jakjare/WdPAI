<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/objects.css">
    <link rel="stylesheet" type="text/css" href="public/css/requests.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/requestsEditor.js" defer></script>
    <title>AdminGate - requests</title>
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
        <div>
            <h1><?php echo $archived ? 'Archived requests' : 'Your requests'; ?></h1>
        </div>
        <div class="option-bar">
            <a class="button" href="newRequest"><button id="newRequestButton">New</button></a>
            <button id="deleteCheckedButton"><?php echo $archived ? 'Unarchive selected' : 'Delete selected'; ?></button>
            <a class="button" href="<?php echo $archived ? 'requests' : 'archiveRequests'; ?>"><button id="archivedButton"><?php echo $archived ? 'Back' : 'Archived'; ?></button></a>
        </div>
        <div id="object-list">
            <table class="objects-table">
                <tr>
                    <th style="width: 10px"><input id="chceck-all" type="checkbox"></th>
                    <th>Sender</th>
                    <th>Topic</th>
                    <th class="hide">Time</th>
                    <th></th>
                </tr>
                <?php foreach ($requests as $request): ?>
                    <tr class="<?php echo $request->isRead() ? '' : 'bold'?>" id="<?php echo $request->getId(); ?>">
                        <td><input type="checkbox"></td>
                        <td class="click"><?php echo $request->getSender()->getName().' '.$request->getSender()->getSurname(); ?></td>
                        <td class="click"><?php echo $request->getTopic(); ?></td>
                        <td class="hide, click"><?php echo $request->getTime(); ?></td>
                        <td><i class="fas fa-archive"></i></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div id="open-request">
            <h1 id="topic"></h1>
            <div>
                <h2 id="from"></h2>
                <h2 id="date"></h2>
                <h2>Device: <a id="device" href=""></a></h2>
            </div>
            <p></p>
        </div>
    </main>
</div>
</body>