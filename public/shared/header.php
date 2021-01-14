<?php session_start() ?>

<a href="dashboard"><img src="public/img/icon_admingate.svg" alt="admingate icon"></a>
<a href="#" class="push"><i class="far fa-bell"></i></a>
<a href="settings"><i class="fas fa-cog"></i></a>
<div class="user-header">
    <p><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?></p>
    <p><?php echo $_SESSION['email']; ?></p>
</div>
<div class="avatar" style="background: transparent url('<?php echo '../public/uploads/users_avatars/'.$_SESSION['image']; ?>') no-repeat center; background-size: 1.8em;"></div>