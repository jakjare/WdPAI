<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/dashboard.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <title>AdminGate - dashboard</title>
    <script>
        function settingsProblem(block_id) {
            block_id = block_id + '-box';
            if (document.getElementById(block_id).style.display == "none")
            {
                document.getElementById(block_id).style.display = "block";

            } else {
                document.getElementById(block_id).style.display = "none";
            }
        }
    </script>
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
                <div>24.11.2020 / 21:58</div>

            </div>
            <div id="online-users" class="info-block">
                <i class="fas fa-user"></i>
                <div>
                    <p>Users online</p>
                    <p>23</p>
                </div>
            </div>
            <div id="online-devices" class="info-block">
                <i class="fas fa-server"></i>
                <div>
                    <p>Devices online</p>
                    <p>64</p>
                </div>
            </div>
            <div id="today-problems" class="info-block">
                <i class="far fa-clock"></i>
                <div>
                    <p>Today's problems</p>
                    <p>2</p>
                </div>
            </div>
            <div id="problems">
                <div>
                    <div>Problems</div>
                    <button id="problem-settings" onclick="settingsProblem('problem-settings')"><i class="fas fa-ellipsis-v"></i><div id="problem-settings-box" class="settings-box" style="display: none;"><a href="login">exit</a></div></button>
                </div>
                <table id="table-problems">
                    <tr>
                        <th style="width: 10%">Time</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 15%">Host</th>
                        <th style="width: 40%">Problems</th>
                        <th style="width: 10%">Duration</th>
                        <th style="width: 10%">Ack</th>
                    </tr>
                    <tr>
                        <td>10:04:12</td>
                        <td>PROBLEM</td>
                        <td>WIN_23_55XJ</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lacinia urna vitae porta. dapibus. Nulla facilisi. [...]</td>
                        <td>27m 30s</td>
                        <td>No</td>
                    </tr>
                </table>
            </div>
            <div id="users">
                <div>
                    <div>Users</div>
                    <a href="users">View all</a>
                </div>
                <table>
                    <tr>
                        <td><div class="avatar"></div></td>
                        <td style="width: 80%">Olivia East</td>
                        <td><button id="user-1-settings" onclick="settingsProblem('user-1-settings')"><i class="fas fa-ellipsis-v"></i><div id="user-1-settings-box" class="settings-box" style="display: none;">callasdasasdasdasadadadadada dadadadadada dadadadadadadadadadada dadadadadaddsadssad</div></button></td>
                    </tr>
                </table>
            </div>
            <div id="room-status">
                <div>
                    <div>Room status</div>
                    <button id="room-settings" onclick="settingsProblem('room-settings')"><i class="fas fa-ellipsis-v"></i><div id="room-settings-box" class="settings-box" style="display: none;">callasdasasdasdadsadssad</div></button>
                </div>
                <table>
                    <tr>
                        <td style="width: 50%">Room_1F_C</td>
                        <td style="width: 25%">3 / 11</td>
                        <td style="width: 25%"><a href="#" class="special">Check</a></td>
                    </tr>
                </table>
            </div>
        </main>
    </div>
</body>