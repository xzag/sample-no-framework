<?php
    $this->setTitle('Login');
?>
<?php if (!empty($error)):?>
<div class="alert alert-danger" role="alert">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif;?>

<form class="form-signin" action="/auth/login" method="post">
    <input type="hidden" name="csrf" value="<?= $this->getApp()->getCSRF() ?>">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus >
    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>
