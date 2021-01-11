<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/objects.css">
    <link rel="stylesheet" type="text/css" href="public/css/settings.css">
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
    <main class="objects">
        <div class="option-bar">
            <input name="search">
            <button type="search"><i class="fas fa-search"></i></button>
            <button id="deviceAddButton">Add device</button>
            <button id="locationAddButton">Add location</button>
        </div>
        <div id="object-list">
            <table class="objects-table">
                <tr>
                    <th style="width: 25%">Device name</th>
                    <th>IP address</th>
                    <th>Location</th>
                    <th>Services</th>
                    <th>Status</th>
                    <th>Online</th>
                    <th></th>
                </tr>
                <?php foreach ($devices as $device): ?>
                <tr id="<?php echo $device->getId(); ?>">
                    <td><?php echo $device->getName(); ?></td>
                    <td><?php echo $device->getIpAddress(); ?></td>
                    <td><?php echo $device->getLocation(); ?></td>
                    <td><?php // TODO ?>-</td>
                    <td id="operation_status" style="color: <?php echo $device->getColorString(); ?>;"><?php echo $device->getOperationStatus(); ?></td>
                    <td><?php echo $device->isStatus() ? 'Up' : 'Down'; ?></td>
                    <td><i class="fas fa-tools"></i><i class="fas fa-trash"></i></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
    <div class="overlay">
        <div id="deviceEditor" class="popup">
            <h1>New device</h1>
            <form id="deviceForm" class="settings-form" action="addDevice" method="post">
                <input name="id" type="text" readonly>
                <div>
                    <div>
                        Device name
                        <input name="name" type="text">
                    </div>
                    <div>
                        IP address
                        <input name="ip" type="text">
                    </div>
                    <div>
                        Admin comment
                        <input name="comment" type="text">
                    </div>
                    <div>
                        Location
                        <select name="location">
                            <?php foreach ($locations as $location): ?>
                            <option value="<?php echo $location->getId(); ?>"><?php echo $location->getName(); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                Users permission
                <select multiple name="permission[]">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->getIdDatabase(); ?>"><?php echo $user->getName().' '.$user->getSurname().' - '.$user->getEmail(); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">confirm</button>
            </form>
            <form id="locationForm" class="settings-form" action="addLocation" method="post">
                <input name="id" type="text" readonly>
                Location name
                <input name="name" type="text">
                <button type="submit">confirm</button>
            </form>
            <button id="exitPopupButton">exit</button>
        </div>
    </div>
</div>
</body>