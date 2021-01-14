<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <script src="https://kit.fontawesome.com/1ac581c2b0.js" crossorigin="anonymous"></script>
    <title>Login to AdminGate</title>
</head>
<body>
    <div class="base-container">
        <div class="graphic"></div>
        <div class="login-container">
            <img src="public/img/logo_admingate.svg" alt="logo">
            <div class="social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
                <a href="#"><i class="fab fa-microsoft"></i></a>
            </div>
            <form action="login" method="post">
                <input name="email" type="text" placeholder="&#xf007;  email">
                <input name="password" type="password" placeholder="&#xf023;  password">
                <?php
                    if(isset($messages)) {
                        foreach ($messages as $message) {
                            echo "<div class=\"messeges\">".$message."</div>";
                        }
                    }
                ?>
                <a href="#">Forgot password?</a>
                <button type="submit">login</button>
                <button>sign in</button>
            </form>
        </div>
    </div>
</body>