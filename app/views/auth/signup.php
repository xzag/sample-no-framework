<?php
/**
 * @var \app\controllers\Controller $this
 * @var \app\requests\SignupRequest $request
 */
$this->setTitle('Signup');
?>
<?php if (!empty($error)):?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif;?>

<form class="form-signin" action="/auth/signup" method="post">
    <input type="hidden" name="csrf" value="<?= $this->getApp()->getCSRF() ?>">
    <h1 class="h3 mb-3 font-weight-normal">Signup</h1>
    <label for="inputLogin" class="sr-only">Login</label>
    <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus value="<?= htmlspecialchars($request->login) ?>">
    <label for="inputEmail" class="sr-only">Email</label>
    <input name="email" type="text" id="inputEmail" class="form-control" placeholder="Email" required  value="<?= htmlspecialchars($request->email)?>">
    <label for="inputName" class="sr-only">Name</label>
    <input name="name" type="text" id="inputName" class="form-control" placeholder="Name" value="<?= htmlspecialchars($request->name)?>" >
    <label for="inputPassword" class="sr-only">Password</label>
    <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Signup</button>
</form>
