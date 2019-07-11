<?php
/**
 * @var \app\controllers\Controller $this
 * @var \app\requests\ProfileRequest $request
 * @var \app\models\User $user
 */
    $this->setTitle('User profile');
?>
<div>
    <h1 class="h3 mb-3 font-weight-normal">User profile</h1>
    <form class="form-signin" action="/auth/logout" method="post">
      <input type="hidden" name="csrf" value="<?= $this->getApp()->getCSRF() ?>">
      <button type="submit" class="btn btn-danger">Logout</button>
    </form>
    <?php if (!empty($error)):?>
      <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($error) ?>
      </div>
    <?php endif;?>
    <div>
        <label>Login: </label><span><?= htmlspecialchars($user->login)?></span>
        <br />
        <label>Email: </label><span><?= htmlspecialchars($user->email)?></span>
    </div>
    <div>
        <form class="form-signin" action="/user/profile" method="post">
            <input type="hidden" name="csrf" value="<?= $this->getApp()->getCSRF() ?>">
            <label for="inputName" class="sr-only">Name</label>
            <input name="name" type="text" id="inputName" class="form-control" placeholder="Name" value="<?= htmlspecialchars($request->name)?>" >
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
        </form>
    </div>
</div>