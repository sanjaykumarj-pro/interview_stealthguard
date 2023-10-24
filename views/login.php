<header>
    <h1>Login</h1>
</header>

<div class="container">
    <div class="content">
        <form method="post" enctype="multipart/form-data" action="">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <?php if(!empty($_SESSION['message'])) echo $_SESSION['message']."<br/><br/>";?>

            Username <input type="text" name="username"/><br/><br/>
            Password <input type="password" name="password"/><br/><br/>
            <input type="submit" value="Go" name="trylogin"/>
        </form>
    </div>
</div>