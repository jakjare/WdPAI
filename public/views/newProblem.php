<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/administration.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/requestsEditor.js" defer></script>
    <title>AdminGate - requests</title>
    <?php session_start(); ?>
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
            <a class="button" href="newProblem"><button id="newRequestButton">New</button></a>
        </div>
        <?php
        if(isset($messages)) {
            foreach ($messages as $message) {
                echo "<div class=\"messages\">".$message."</div>";
            }
        }
        ?>
        <div class="new-problem">
            <form method="post" action="addProblem">
                <h2>Choice device:</h2>
                <select name="id_device">
                    <?php foreach ($devices as $device): ?>
                        <option value="<?php echo $device->getId(); ?>"><?php echo $device->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea name="description" placeholder="Here type description of the problem."></textarea>
                <button type="submit">submit</button>
            </form>
        </div>
    </main>
</div>
</body>