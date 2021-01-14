<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/error.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <title>AdminGate - error</title>
</head>
<body>
<div class="error-container">
    <img src="public/img/logo_admingate.svg" alt="logo">
    <div>
        <p><i class="fas fa-car-crash"></i> Something went wrong!</p>
        <?php
        if(isset($messages)) {
            foreach ($messages as $message) {
                echo "<div class=\"messeges\">".$message."</div>";
            }
        }
        ?>
    </div>
    <a href="login"><button>login page</button></a>
</div>
</body>