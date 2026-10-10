<?= $this->include('templates/header') ?>

<section class="page-heading">
    <h1>Sign Up</h1>
</section>

<?php if (isset($validation) && $validation->getErrors()): ?>
    <div class="alert alert-danger" role="alert"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form action="<?= base_url('signup') ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" type="text" value="<?= old('full_name') ?>" maxlength="100" autocomplete="name" required autofocus>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= old('username') ?>" minlength="3" maxlength="50" autocomplete="username" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone number (optional)</label>
        <input id="phone" name="phone" type="tel" value="<?= old('phone') ?>" maxlength="20" autocomplete="tel">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" required>
    </div>
    <div class="form-group">
        <label for="password_confirm">Confirm password</label>
        <input id="password_confirm" name="password_confirm" type="password" minlength="8" autocomplete="new-password" required>
    </div>
    <button class="button" type="submit">Create account</button>
</form>
<p>Already have an account? <a href="<?= base_url('login') ?>">Log in</a></p>

<?= $this->include('templates/footer') ?>
