<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/requests.css">
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
            <a class="button" href="newRequest"><button id="newRequestButton">New</button></a>
            <button id="deleteCheckedButton">Delete</button>
            <a class="button" href="archiveRequests"><button id="archivedButton">Archived</button></a>
        </div>
        <?php
        if(isset($message))
        {
            echo "<div class=\"messeges\">".$message."</div>";
        }
        ?>
        <div class="request-form-div">
            <form action="addRequest" method="post">
                <div id="contacts">
                    <h2>Contacts</h2>
                    <table>
                        <?php foreach ($users as $user):
                            if($user->getEmail() == $_SESSION['email'])
                            {
                                continue;
                            }
                            ?>
                        <tr id="<?php echo $user->getIdDatabase(); ?>">
                            <td><div class="avatar" style="background: transparent url('<?php echo '../public/uploads/users_avatars/'.$user->getImage(); ?>') no-repeat center; background-size: 1.8em;"></div></td>
                            <td style="width: 80%;"><?php echo $user->getName().' '.$user->getSurname(); ?></td>
                            <td class="select-user"><label class="select-user"><input type="checkbox" name="id_receivers[]" value="<?php echo $user->getIdDatabase(); ?>"><i class="fas fa-plus"></i></label></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <select name="device">
                    <option value="null">select device</option>
                    <?php foreach ($devices as $device): ?>
                    <option value="<?php echo $device->getId(); ?>"><?php echo $device->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
                <input name="topic" type="text" placeholder="Topic">
                <textarea name="content"></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </main>
</div>
</body>