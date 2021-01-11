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
            <input name="search">
            <button type="search"><i class="fas fa-search"></i></button>
            <button id="newRequestButton">New</button>
            <button id="archiveButton">Archive</button>
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
                    <tr id="">
                        <td><input type="checkbox"></td>
                        <td>Olivia East</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</td>
                        <td>2020.11.03 10:02:03</td>
                        <td><i class="fas fa-archive"></i></td>
                    </tr>
            </table>
        </div>
    </main>
</div>
</body>