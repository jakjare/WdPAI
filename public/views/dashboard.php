<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/dashboard.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
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
        <main class="dashboard">
            <div id="status">
                <div style="font-weight: bold;">Your dashboard</div>
                <div class="special">server time</div>
                <div>
                    <?php session_start();
                    echo substr($_SESSION['server-time'], 0, 19); ?>
                </div>

            </div>
            <div id="online-users" class="info-block">
                <i class="fas fa-user"></i>
                <div>
                    <p>Users online</p>
                    <p><?php echo $users_online; ?></p>
                </div>
            </div>
            <div id="online-devices" class="info-block">
                <i class="fas fa-server"></i>
                <div>
                    <p>Devices online</p>
                    <p><?php echo $devices_online; ?></p>
                </div>
            </div>
            <div id="today-problems" class="info-block">
                <i class="far fa-clock"></i>
                <div>
                    <p>Unsolved problems</p>
                    <p><?php echo count($problems); ?></p>
                </div>
            </div>
            <div id="problems">
                <div>
                    <div>Problems</div>
                </div>
                <table id="table-problems">
                    <tr>
                        <th style="width: 10%">Time</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%">Host</th>
                        <th style="width: 40%">Description</th>
                        <th style="width: 10%">Duration</th>
                        <th style="width: 10%">Ack</th>
                    </tr>
                    <?php foreach ($problems as $problem): ?>
                    <tr>
                        <td><?php echo $problem->getDate(); ?></td>
                        <td><?php echo strtoupper($problem->getProblemStatus()); ?></td>
                        <td><?php echo $problem->getDevice(); ?></td>
                        <td><?php echo $problem->getDescription(); ?></td>
                        <td><?php echo $problem->getDuration(); ?></td>
                        <td><?php echo $problem->getAckUser() != null ? "Yes" : "No"; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div id="users">
                <div>
                    <div>Users</div>
                </div>
                <table>
                    <?php foreach ($users as $user):
                        if ($user->getEmail() == $_SESSION['email']) {
                            continue;
                        } ?>
                    <tr>
                        <td><div class="avatar" style="background: transparent url('<?php echo '../public/uploads/users_avatars/'.$user->getImage(); ?>') no-repeat center; background-size: 1.8em;"></div></td>
                        <td style="width: 80%"><?php echo $user->getName().' '.$user->getSurname(); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </main>
    </div>
</body>