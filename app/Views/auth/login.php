<?= $this->include('templates/header') ?>

<section class="page-heading">
    <h1>Login</h1>
</section>

<?php if (! empty($error)): ?>
    <p class="alert alert-danger" role="alert"><?= esc($error) ?></p>
<?php endif; ?>
<?php if (session()->getFlashdata('message')): ?>
    <p class="alert alert-success" role="status"><?= esc(session()->getFlashdata('message')) ?></p>
<?php endif; ?>

<form action="<?= base_url('login') ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" value="<?= esc($username ?? '') ?>" autocomplete="username" required autofocus>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>
    <button class="button" type="submit">Login</button>
</form>
<p>Don't have an account? <a href="<?= base_url('signup') ?>">Sign up</a></p>

<?= $this->include('templates/footer') ?>
