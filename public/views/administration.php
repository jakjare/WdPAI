<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/administration.css">
    <link rel="stylesheet" type="text/css" href="public/css/objects.css">
    <link rel="stylesheet" type="text/css" href="public/css/settings.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/administrationScript.js" defer></script>
    <title>AdminGate - admin panel</title>
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
        <main>
            <div><h1>Administrator's panel</h1></div>
            <div class="option-bar, option-bar-1">
                <input name="search">
                <button type="search"><i class="fas fa-search"></i></button>
                <a href="newProblem"><button><i class="fas fa-plus"></i></button></a>
            </div>
            <div class="problems">
                <?php foreach ($problems as $problem): ?>
                <div class="problem-box">
                    <h2>STATUS: <?php echo strtoupper($problem->getProblemStatus()); ?></h2>
                    <i class="far fa-clock"></i><label><?php echo $problem->getDate(); ?></label>
                    <i class="fas fa-server"></i><label><?php echo $problem->getDevice()->getName(); ?></label>
                    <i class="fas fa-hammer"></i><label><?php echo $problem->getAckUser() == null ? 'No' : $problem->getAckUser()->getName()." ".$problem->getAckUser()->getSurname(); ?></label>
                    <i class="fas fa-hourglass-half"></i><label><?php echo $problem->getDuration(); ?></label>
                    <i class="fas fa-address-card"></i><label><?php echo $problem->getReportingUser()->getName()." ".$problem->getReportingUser()->getSurname(); ?></label>
                    <p><?php echo $problem->getDescription(); ?></p>
                    <button id="<?php echo $problem->getId(); ?>"><i class="fas fa-info"></i></button>
                    <button><i class="fas fa-reply"></i></button>
                    <button><i class="fas fa-check"></i></button>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="option-bar, option-bar-2">
                <button><i class="fas fa-laptop-medical"></i>  remote controll</button>
                <button><i class="fas fa-redo"></i></button>
                <button><i class="fas fa-chart-bar"></i></button>
            </div>
            <div class="more-info">
                <h2>Click info button to load more information.</h2>
            </div>
        </div>
        </main>
        <div class="overlay">
            <div id="problemReply" class="popup">
                <h1>Send reply</h1>
                <form id="problemReplyForm" class="settings-form" action="replyProblem" method="post">
                    <input name="id" type="text" readonly>
                    <div>
                        <div>
                            Change status
                            <select name="status">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?php echo $status->getId(); ?>"><?php echo $status->getName(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    Request
                    <textarea name="content" placeholder="Here type your request."></textarea>
                    <button type="submit">send</button>
                </form>
                <button id="exitPopupButton">exit</button>
            </div>
        </div>
    </div>
</body>

<template id="more-info-template">
    <h2>Device information:</h2>
    <div class="device-info">
        <h2>Status information:</h2>
        <h3>Current state</h3><label id="state"></label>
        <h3>IP address</h3><label id="ip"></label>
        <h3>Last status update</h3><label>-</label>
        <h3>Last status change</h3><label>-</label>
        <h2>Specific information:</h2>
        <p></p>
    </div>
    <h2>Permissions:</h2>
    <div id="object-list">
        <table id="permissions-table" class="objects-table">
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th></th>
            </tr>
        </table>
    </div>
    <h2>Problem history:</h2>
    <div class="problem-history">
        <div id="object-list">
            <table id="problem-history-table" class="objects-table">
                <tr>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Time</th>
                    <th>Reported person</th>
                    <th>Action person</th>
                    <th></th>
                </tr>
            </table>
        </div>
</template>

<template id="permission-table-buttons-template">
    <td>
        <button id=""><i class="fas fa-paper-plane"></i></button>
        <button id=""><i class="fas fa-user-slash"></i></button>
    </td>
</template>

<template id="problem-history-table-buttons-template">
    <td><button id=""><i class="fas fa-info"></i></button></td>
</template>