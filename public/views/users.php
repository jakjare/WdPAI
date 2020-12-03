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
            include_once("public/shared/header.php");
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
                <tr>
                    <td>Olivia</td>
                    <td>East</td>
                    <td>olivia_east@email.com</td>
                    <td>Admin</td>
                    <td>Active</td>
                    <td>1.12.2020 / 11:11</td>
                    <td><i class="fas fa-user-edit"></i><i class="fas fa-user-lock"></i><i class="fas fa-trash"></i></td>
                </tr>
            </table>
        </div>
    </main>
</div>
</body>