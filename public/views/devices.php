<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/devices.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <title>AdminGate - dashboard</title>
</head>
<body>
<div class="base-container">
    <header>
        <?php
        $this->header();
        ?>
    </header>
    <nav>
        <?php
        $this->menu();
        ?>
    </nav>
    <main class="devices">
        <div id="filter">
            <i class="fas fa-filter"></i>
            <form>
                <div>
                    Device name
                    <input name="name" type="text">
                </div>
                <div>
                    IP address
                    <input name="ip-address" type="text">
                </div>
                <div>
                    Service
                    <input name="service" type="text">
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
                    <th style="width: 25%">Device name</th>
                    <th>IP address</th>
                    <th>Location</th>
                    <th>Services</th>
                    <th>Status</th>
                    <th>Online</th>
                    <th></th>
                </tr>
                <tr>
                    <td>DEVICE_1</td>
                    <td>192.168.1.1</td>
                    <td>RACK_12X</td>
                    <td>router</td>
                    <td>Normal operation</td>
                    <td>Up</td>
                    <td><i class="fas fa-tools"></i><i class="fas fa-trash"></i></td>
                </tr>
                <tr>
                    <td>DEVICE_1</td>
                    <td>192.168.1.1</td>
                    <td>RACK_12X</td>
                    <td>router</td>
                    <td>Normal operation</td>
                    <td>Up</td>
                    <td><i class="fas fa-tools"></i><i class="fas fa-trash"></i></td>
                </tr>
            </table>
        </div>
    </main>
</div>
</body>