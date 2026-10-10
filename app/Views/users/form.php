<?= $this->include('templates/header') ?>

<section class="page-heading">
    <h1><?= esc($title) ?></h1>
</section>

<?php if (session()->getFlashdata('error')): ?><p class="alert error"><?= esc(session()->getFlashdata('error')) ?></p><?php endif; ?>
<?php if (isset($validation) && $validation->getErrors()): ?><div class="alert error"><?= $validation->listErrors() ?></div><?php endif; ?>

<form action="<?= esc($action) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" value="<?= old('username', $user['username'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" value="<?= old('full_name', $user['full_name'] ?? '') ?>" required>
    </div>
    <button class="button" type="submit">Save User</button>
    <a href="<?= base_url('users') ?>">Cancel</a>
</form>

<?= $this->include('templates/footer') ?>
