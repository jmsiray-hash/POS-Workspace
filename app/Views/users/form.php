<?= $this->include('templates/header') ?>

<section class="page-heading">
    <h1><?= esc($title) ?></h1>
</section>

<?php if (session()->getFlashdata('error')): ?><p class="alert error"><?= esc(session()->getFlashdata('error')) ?></p><?php endif; ?>
<?php if (isset($validation) && $validation->getErrors()): ?><div class="alert error"><?= $validation->listErrors() ?></div><?php endif; ?>

<form action="<?= esc($action) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="username">Username</label>
        <input id="username" name="username" value="<?= old('username', $user['username'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="full_name">Full name</label>
        <input id="full_name" name="full_name" value="<?= old('full_name', $user['full_name'] ?? '') ?>" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone number</label>
        <input id="phone" name="phone" type="tel" value="<?= old('phone', $user['phone'] ?? '') ?>" maxlength="20" autocomplete="tel">
    </div>
    <div class="form-group">
        <label for="password">Password<?= ($title ?? '') === 'Edit User' ? ' (leave blank to keep current)' : '' ?></label>
        <input id="password" name="password" type="password" minlength="8" autocomplete="new-password" <?= ($title ?? '') === 'Edit User' ? '' : 'required' ?>>
    </div>
    <div class="form-group">
        <label for="avatar">Photo (JPEG, PNG, or WebP; max 2 MB)</label>
        <?php if (! empty($user['avatar'])): ?>
            <div class="current-avatar"><img class="avatar" src="<?= base_url($user['avatar']) ?>" alt="Current user photo"></div>
        <?php endif; ?>
        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp">
    </div>
    <button class="button" type="submit">Save User</button>
    <a href="<?= base_url('users') ?>">Cancel</a>
</form>

<?= $this->include('templates/footer') ?>
